@extends('layouts.auth')

@section('content')
<div class="page page-center">
    <div class="container-fluid">
        <div class="row align-items-center g-0 min-vh-100">
            <!-- Left side - Clinic Info -->
            <div class="col-lg-6 d-none d-lg-block">
                <div class="clinic-banner p-5 h-100 d-flex flex-column justify-content-start" 
                     style="background-color: #0054a6;">
                    <div class="text-white mb-5">
                        <h1 class="display-4 fw-bold mb-3">VetCare Clinic</h1>
                        <p class="lead mb-4">Providing the best care for your beloved pets</p>
                    </div>
                    <div class="features text-white">
                        <div class="feature-item mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-stethoscope me-3"></i>
                                <span>Professional Veterinary Services</span>
                            </div>
                        </div>
                        <div class="feature-item mb-4">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-clock me-3"></i>
                                <span>24/7 Emergency Care</span>
                            </div>
                        </div>
                        <div class="feature-item">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-check me-3"></i>
                                <span>Online Appointment Booking</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right side - Login Form -->
            <div class="col-lg-6">
                <div class="container py-4" style="max-width: 400px;">
                    <div class="text-center mb-4">
                        <a href="/" class="navbar-brand navbar-brand-autodark">
                            <img src="{{ asset('assets/img2/logo.png') }}" height="36" alt="VetCare">
                        </a>
                    </div>
                    <div class="card">
                        <div class="card-body p-4">
                            <h2 class="text-center mb-4">Welcome Back!</h2>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email address</label>
                                    <input type="email" 
                                           name="email" 
                                           class="form-control @error('email') is-invalid @enderror" 
                                           placeholder="your@email.com"
                                           value="{{ old('email') }}" 
                                           required 
                                           autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label mb-0">Password</label>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="small text-muted">
                                                Forgot password?
                                            </a>
                                        @endif
                                    </div>
                                    <input type="password" 
                                           name="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           placeholder="Your password" 
                                           required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4">
                                    <label class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input"/>
                                        <span class="form-check-label">Remember me</span>
                                    </label>
                                </div>
                                <div class="form-footer">
                                    <button type="submit" class="btn btn-primary w-100">
                                        Sign in
                                    </button>
                                </div>
                            </form>

                            <div class="text-center mt-4 pt-2 border-top">
                                <p class="text-muted mb-0">
                                    New to VetCare? 
                                    <a href="{{ route('register') }}" class="ms-1">Create an account</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .page {
        background-color: #f5f7fb;
    }
    
    .clinic-banner {
        background-color: #0054a6;
    }

    .card {
        border: none;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        max-width: 100%;
    }

    .form-control {
        border-radius: 4px;
        padding: 0.6rem 1rem;
        border-color: #e4e6ef;
    }

    .form-control:focus {
        border-color: #0054a6;
        box-shadow: 0 0 0 0.2rem rgba(0, 84, 166, 0.25);
    }

    .btn-primary {
        background-color: #0054a6;
        border-color: #0054a6;
        padding: 0.6rem 1rem;
        font-weight: 500;
        border-radius: 4px;
    }

    .btn-primary:hover {
        background-color: #004385;
        border-color: #004385;
    }

    .feature-item {
        font-size: 1.1rem;
    }

    .feature-item i {
        width: 24px;
    }

    @media (max-width: 992px) {
        .container {
            padding: 1rem;
        }
    }

    @media (max-width: 576px) {
        .card {
            margin: 0 10px;
        }
        .container {
            padding: 0;
        }
    }
</style>
@endsection
