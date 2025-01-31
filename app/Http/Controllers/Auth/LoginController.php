<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->isPetOwner()) {
            return redirect()->route('pet-owner.dashboard');
        }
        
        return redirect()->intended(RouteServiceProvider::HOME);
    }

    protected function attemptLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        // Find the user first
        $user = User::where('email', $request->email)->first();
        
        if ($user && !$user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'Please verify your email address before logging in.',
                'verification_required' => true
            ], 403);
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            return response()->json([
                'success' => true,
                'redirect' => route('pet-owner.dashboard')
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid login credentials'
        ], 422);
    }

    protected function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if the user exists and is verified
        $user = User::where('email', $request->email)->first();
        
        if ($user && is_null($user->email_verified_at)) {
            return back()->withErrors([
                'email' => 'Please verify your email address before logging in.',
            ])->withInput($request->only('email', 'remember'));
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        return $this->sendFailedLoginResponse($request);
    }
} 