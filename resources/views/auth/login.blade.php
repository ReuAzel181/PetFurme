@extends('layouts.auth')

@section('head')
    <link rel="stylesheet" href="{{ asset('public/styles1.css') }}">
    <style>
        .login-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
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

        .login-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card {
            width: 100%;
            max-width: 420px;
            border-radius: 15px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.18);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-body {
            padding: 2.5rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid rgba(255, 255, 255, 0.4);
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #4a6cf7;
            box-shadow: 0 0 0 2px rgba(74, 108, 247, 0.1);
            background: white;
        }

        .btn-primary {
            background: linear-gradient(45deg, #4a6cf7, #3451b2);
            border: none;
            padding: 0.75rem;
            border-radius: 8px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #3451b2, #4a6cf7);
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
        }

        .text-secondary a {
            color: #4a6cf7;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .text-secondary a:hover {
            color: #3451b2;
            text-decoration: none;
        }

        h2 {
            color: #2d3748;
            font-weight: 600;
        }

        .form-label {
            color: #4a5568;
            font-weight: 500;
        }
    </style>
@endsection

@section('content')
<div class="login-container">
    <div class="side-bar">
        <h1 class="main-title">
            Customize your pet based on your preferences
        </h1>
        <img src="assets/img2/login_icon.png" alt="Login Icon">
    </div>

    <div class="login-form-container">
        <div class="card">
            <div class="card-body">
                <h2 class="h2 text-center mb-4">
                    Login to your account
                </h2>
                <form action="{{ route('login') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            Email address
                        </label>
                        <input type="email"
                            name="email"
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="your@email.com"
                            autocomplete="off"
                            value="{{ old('email') }}"
                        >
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            Password
                        </label>
                        <input type="password"
                            name="password"
                            id="password"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Your password"
                            autocomplete="off"
                        >
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="remember" class="form-check">
                            <input type="checkbox" id="remember" name="remember" class="form-check-input"/>
                            <span class="form-check-label">Remember me on this device</span>
                        </label>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn btn-primary w-100">
                            Sign in
                        </button>
                    </div>
                </form>

                <div class="text-center text-secondary mt-4">
                    <div class="mb-2">
                        Don't have account yet? <a href="{{ route('register') }}" tabindex="-1">Sign up</a>
                    </div>
                    <div>
                        <a href="{{ route('password.request') }}">I forgot password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
