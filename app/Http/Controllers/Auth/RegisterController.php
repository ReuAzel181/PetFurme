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
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ]);

        // Generate 6 digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store registration data and OTP in session
        $request->session()->put('registration_data', $request->all());
        
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

        return back()->with([
            'verify_otp' => true,
            'email' => $request->email,
            'status' => 'We have sent an OTP to your email address.'
        ]);
    }

    public function verifyOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $passwordReset = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$passwordReset) {
            return back()->withErrors([
                'otp' => 'Invalid or expired OTP.'
            ]);
        }

        // Get registration data from session
        $data = $request->session()->get('registration_data');
        
        // Create user
        $user = User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Delete used OTP
        $passwordReset->delete();
        
        // Clear session data
        $request->session()->forget(['registration_data', 'verify_otp']);

        // Log the user in
        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('status', 'Your account has been created successfully!');
    }
} 