@extends('layouts.auth')

@section('head')
    <style>
        .forgot-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            padding: 2rem;
        }

        .forgot-form-container {
            width: 100%;
            max-width: 500px;
            margin: auto;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            overflow: hidden;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 20px;
        }

        .card-body {
            padding: 3rem;
        }

        .card-title {
            color: #6D28D9;
            font-size: 2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }

        .text-secondary {
            color: #6B7280;
            text-align: center;
            font-size: 1rem;
            line-height: 1.5;
        }

        .form-control {
            background: #F3F4F6;
            border: none;
            border-radius: 10px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: #fff;
            box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.3);
        }

        .form-label {
            color: #4B5563;
            margin-bottom: 0.5rem;
            font-weight: 500;
        }

        .btn-primary {
            background: #8B5CF6;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 1rem;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            background: #7C3AED;
            transform: translateY(-2px);
        }

        .btn-primary svg {
            width: 20px;
            height: 20px;
        }

        .text-center a {
            color: #8B5CF6;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .text-center a:hover {
            color: #7C3AED;
        }

        @media (max-width: 640px) {
            .forgot-form-container {
                margin: 1rem;
            }
            
            .card-body {
                padding: 2rem;
            }
        }
    </style>
@endsection

@section('content')
<div class="forgot-container">
    <div class="forgot-form-container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">
                    Forgot Password
                </h2>

                <p class="text-secondary mb-4">
                    Enter your email address and we'll send you instructions to reset your password.
                </p>

                <form action="{{ route('password.email') }}" method="post" autocomplete="off" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">
                            Email address
                        </label>
                        <input type="email" 
                            name="email" 
                            id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="Enter your email"
                        >

                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                            <path d="M3 7l9 6l9 -6" />
                        </svg>
                        Send OTP
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('login') }}">
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
