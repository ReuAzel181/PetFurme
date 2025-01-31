@extends('layouts.auth')

@section('head')
    <style>
        .register-container {
            display: flex;
            min-height: 100vh;
            background-color: #f5f7fb;
        }

        .side-bar {
            flex: 1;
            background-color: #4a6cf7;
            color: white;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .main-title {
            font-size: 2.5rem;
            margin-bottom: 2rem;
            line-height: 1.3;
            font-weight: 600;
        }

        .side-bar img {
            max-width: 80%;
            height: auto;
            margin-top: 2rem;
        }

        .register-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            width: 100%;
            max-width: 480px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            background: white;
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e2e8f0;
        }

        .form-control:focus {
            border-color: #4a6cf7;
            box-shadow: 0 0 0 2px rgba(74, 108, 247, 0.1);
        }

        .btn-primary {
            background-color: #4a6cf7;
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #3451b2;
            transform: translateY(-1px);
        }

        .text-secondary a {
            color: #4a6cf7;
            text-decoration: none;
        }

        .text-secondary a:hover {
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
<div class="register-container">
    <div class="register-form-container">
        <div class="card">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">Create new account</h2>

                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                @if (!session('verify_otp') && !old('verify_otp'))
                <!-- Registration Form -->
                <form action="{{ route('register') }}" method="POST" autocomplete="off">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}"
                            required
                            placeholder="Enter your full name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email') }}"
                            required
                            placeholder="Enter your email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            required
                            placeholder="Create a password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="form-control"
                            required
                            placeholder="Confirm your password">
                    </div>

                    <div class="mb-3">
                        <div class="form-check">
                            <input type="checkbox" name="terms-of-service" id="terms-of-service" 
                                   class="form-check-input @error('terms-of-service') is-invalid @enderror">
                            <label class="form-check-label" for="terms-of-service">
                                I agree to the Terms of Service
                            </label>
                            @error('terms-of-service')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Create Account</button>
                </form>
                @else
                <!-- OTP Verification Form -->
                <form action="{{ route('register.verify-otp') }}" method="POST" autocomplete="off">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    
                    <div class="mb-4">
                        <label for="otp" class="form-label">Enter OTP</label>
                        <input type="text" 
                            name="otp" 
                            id="otp"
                            class="form-control @error('otp') is-invalid @enderror"
                            placeholder="Enter 6-digit OTP"
                            maxlength="6"
                        >
                        @error('otp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Verify & Create Account
                    </button>
                </form>
                @endif

                <div class="text-center text-secondary mt-4">
                    Already have account? <a href="{{ route('login') }}" tabindex="-1">Sign in</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
