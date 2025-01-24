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
            'otp' => 'required|digits:6'
        ]);

        if (!$this->verifyOTPCode($request->otp)) {
            return back()
                ->withInput()
                ->withErrors(['otp' => 'Invalid or expired OTP.'])
                ->with('verify_otp', true);
        }

        // Get registration data from session
        $data = $request->session()->get('registration_data');
        
        // Create user with pet_owner role
        $user = User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'pet_owner'  // Set the role here
        ]);

        // Delete used OTP
        PasswordResetOtp::where('email', session('email'))->delete();
        
        // Clear session data
        $request->session()->forget(['registration_data', 'verify_otp']);

        // Log the user in
        Auth::login($user);

        return redirect()->route('pet-owner.dashboard')
            ->with('status', 'Your account has been created successfully!');
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
} 