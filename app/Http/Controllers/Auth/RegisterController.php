<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Http\Requests\User\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Mail\OTPMail;

class RegisterController extends Controller
{
    public function sendOTP(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'terms' => 'required',
        ]);

        // Log the incoming request data for debugging
        \Log::info('Registration request data:', $request->all());

        // Generate 6 digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store the registration data and verify_otp flag in session
        $request->session()->put([
            'verify_otp' => true,
            'registration_data' => $request->except('password_confirmation', 'terms'),
            'email' => $request->email
        ]);
        
        // Store OTP in database
        PasswordResetOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]
        );

        // Send OTP email
        Mail::send('emails.registration-otp', ['otp' => $otp], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Registration OTP Verification');
        });

        return back()->with('status', 'OTP has been sent to your email.');
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6'
        ]);

        $storedOtp = PasswordResetOtp::where('email', session('email'))
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$storedOtp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired verification code'
            ], 422);
        }

        try {
            // Find the unverified user
            $user = User::where('email', session('email'))
                ->whereNull('email_verified_at')
                ->first();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found or already verified'
                ], 422);
            }

            // Mark user as verified
            $user->email_verified_at = now();
            $user->save();

            // Clear verification data
            session()->forget(['registration_data', 'email']);
            $storedOtp->delete();

            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully! You can now login.',
                'redirect' => route('login')
            ]);
        } catch (\Exception $e) {
            \Log::error('Verification error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify email. Please try again.'
            ], 500);
        }
    }

    /**
     * Verify if the OTP code is valid
     * 
     * @param string $otp
     * @return bool
     */
    private function verifyOTPCode($otp)
    {
        $passwordReset = PasswordResetOtp::where('email', session('email'))
            ->where('otp', $otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        return $passwordReset !== null;
    }

    public function register(Request $request)
    {
        try {
            // Validate the request
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|confirmed|min:8',
                'username' => 'required|string|unique:users',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Store registration data in session
            $request->session()->put([
                'registration_data' => $request->all(),
                'email' => $request->email
            ]);

            // Generate OTP
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            // Create unverified user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'pet_owner',
                'username' => $request->username,
                'email_verified_at' => null // Mark as unverified
            ]);

            // Store OTP
            PasswordResetOtp::updateOrCreate(
                ['email' => $request->email],
                [
                    'otp' => $otp,
                    'expires_at' => now()->addMinutes(10)
                ]
            );

            try {
                // Send verification email
                Mail::to($request->email)->send(new OTPMail($otp));
                
                return response()->json([
                    'success' => true,
                    'message' => 'Please check your email for the verification code.',
                    'verify_otp' => true
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to send verification email', [
                    'error' => $e->getMessage(),
                    'trace' => $e->getTraceAsString()
                ]);

                // Delete the unverified user since email failed
                $user->delete();

                return response()->json([
                    'success' => false,
                    'message' => 'Unable to send verification email. Please try again.'
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Registration error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to process registration. Please try again.'
            ], 500);
        }
    }

    public function checkEmail(Request $request)
    {
        $exists = User::where('email', $request->email)->exists();
        
        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'This email is already taken. Please use a different email or login instead.' : 'Email available'
        ]);
    }

    public function checkEmailDelivery(Request $request)
    {
        $email = session('email');
        
        if (!$email) {
            return response()->json([
                'success' => false,
                'message' => 'Email session expired'
            ]);
        }

        $otp = PasswordResetOtp::where('email', $email)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP expired or not found'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Email sent successfully'
        ]);
    }

    public function resendVerification(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)
            ->whereNull('email_verified_at')
            ->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found or already verified'
            ], 422);
        }

        // Generate new OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store new OTP
        PasswordResetOtp::updateOrCreate(
            ['email' => $user->email],
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10)
            ]
        );

        try {
            Mail::to($user->email)->send(new OTPMail($otp));
            
            return response()->json([
                'success' => true,
                'message' => 'Verification code has been resent to your email.'
            ]);
        } catch (\Exception $e) {
            \Log::error('Failed to resend verification email', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to send verification code. Please try again.'
            ], 500);
        }
    }
} 