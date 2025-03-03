@extends('layouts.auth')

@section('head')
    <style>
        .otp-container {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, #8B5CF6, #7C3AED);
            padding: 2rem;
        }

        .otp-form-container {
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

        /* Rest of the styles similar to forgot-password.blade.php */
    </style>
@endsection

@section('content')
<div class="otp-container">
    <div class="otp-form-container">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">
                    Verify OTP
                </h2>

                @if (session('status'))
                    <div class="alert alert-success mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <p class="text-secondary mb-4">
                    Please enter the OTP sent to your email address.
                </p>

                <form action="{{ route('password.verify-otp') }}" method="post" autocomplete="off">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">

                    <div class="mb-4">
                        <label for="otp" class="form-label">
                            Enter OTP
                        </label>
                        <input type="text" 
                            name="otp" 
                            id="otp"
                            class="form-control @error('otp') is-invalid @enderror"
                            placeholder="Enter 6-digit OTP"
                            maxlength="6"
                        >

                        @error('otp')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Verify OTP
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="{{ route('password.request') }}">
                        Resend OTP
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 