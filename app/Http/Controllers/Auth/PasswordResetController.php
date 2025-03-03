<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordResetOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function sendOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'We cannot find a user with that email address.'
            ]);
        }

        // Generate 6 digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // Store OTP in database
        PasswordResetOtp::updateOrCreate(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'expires_at' => Carbon::now()->addMinutes(10)
            ]
        );

        // Send OTP email
        Mail::send('emails.password-reset-otp', ['otp' => $otp], function($message) use ($request) {
            $message->to($request->email);
            $message->subject('Password Reset OTP');
        });

        return redirect()->route('password.otp')->with([
            'email' => $request->email,
            'status' => 'We have sent an OTP to your email address.'
        ]);
    }

    public function showOTPForm()
    {
        return view('auth.verify-otp');
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

        return redirect()->route('password.reset')->with([
            'email' => $request->email,
            'status' => 'Please set your new password.'
        ]);
    }

    public function showResetForm(Request $request)
    {
        if (!$request->session()->has('email')) {
            return redirect()->route('password.request');
        }
        return view('auth.reset-password', ['email' => $request->session()->get('email')]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete used OTP
        PasswordResetOtp::where('email', $request->email)->delete();

        return redirect()->route('login')
            ->with('status', 'Your password has been reset successfully.');
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }
} 