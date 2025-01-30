@extends('layouts.auth')

@section('content')
<div class="page page-center">
    <div class="background-shapes">
        <div class="circle-1"></div>
        <div class="circle-2"></div>
        <div class="circle-3"></div>
        <div class="circle-4"></div>
        <div class="circle-5"></div>
    </div>
    <div class="container-xl py-4">
        <div class="auth-card">
            <div class="row g-0">
                <!-- Carousel Section -->
                <div class="col-lg-6 d-none d-lg-block carousel-side">
                    <div class="welcome-header">
                        <h1 class="display-5 fw-bold text-white mb-2" style="font-weight: bolder !important; text-shadow: 2px 2px 10px rgba(50, 50, 50, 0.5);  margin-bottom: -5px !important;">VetCare</h1>
                        <p class="text-white-50 fs-5">Where caring means more.</p>
                    </div>
                    
                    <div id="authCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="{{ asset('storage/carousel/Carousel1.jpg') }}" class="carousel-image" alt="Welcome">
                                <div class="carousel-overlay"></div>
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('storage/carousel/Carousel2.jpg') }}" class="carousel-image" alt="Services">
                                <div class="carousel-overlay"></div>
                        </div>
                            <div class="carousel-item">
                                <img src="{{ asset('storage/carousel/Carousel3.jpg') }}" class="carousel-image" alt="Health">
                                <div class="carousel-overlay"></div>
                            </div>
                        </div>
                        <div class="carousel-controls">
                            <div class="carousel-indicators">
                                <span class="indicator active" data-bs-target="#authCarousel" data-bs-slide-to="0"></span>
                                <span class="indicator" data-bs-target="#authCarousel" data-bs-slide-to="1"></span>
                                <span class="indicator" data-bs-target="#authCarousel" data-bs-slide-to="2"></span>
                        </div>
                    </div>
                </div>
            </div>

                <!-- Login Form Section -->
            <div class="col-lg-6">
                    <div class="login-section">
                        <div class="form-header text-center">
                            <img src="{{ asset('storage/defaults/vc_logo.png') }}" alt="VetCare Logo" height="66" class="navbar-brand-image">
                            <div id="headerText">
                                <h2 class="text-primary fw-bold">Welcome Back!</h>
                                <p class="text-muted">Please sign in to continue</p>
                    </div>
                                </div>

                        <div class="form-container">
                            <!-- Login Form -->
                            <div class="login-form-container" id="loginForm" style="margin-bottom: 70px;">
                                <form action="{{ route('login') }}" method="POST" autocomplete="off">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email address</label>
                                    <div class="input-icon">
                                        <span class="input-icon-addon">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
                                        </span>
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="your@email.com" value="{{ old('email') }}" required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            The email or password you entered is incorrect. Please try again.
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                        <label class="form-label mb-0">Password</label>
                                        @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}" class="text-muted small">Forgot password?</a>
                                        @endif
                                    </div>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                                            </span>
                                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Your password" required>
                                            <span class="input-icon-addon">
                                                <a href="#" class="link-secondary toggle-password">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                                                </a>
                                            </span>
                                        </div>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            The email or password you entered is incorrect. Please try again.
                                        </div>
                                    @enderror
                                </div>

                                    <div class="mb-3">
                                    <label class="form-check">
                                        <input type="checkbox" name="remember" class="form-check-input"/>
                                            <span class="form-check-label">Keep me signed in</span>
                                    </label>
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Sign in</button>
                                    </div>
                                </form>
                                <div class="text-center mt-4" style="margin-top: 10px !important;">
                                    <span class="text-muted" style="font-size: 12px;">Don't have an account?</span>
                                    <a href="#" class="text-primary ms-2 fw-bold" id="toggleForm" style="font-size: 13px;">Create account</a>
                                </div>
                            </div>

                            <!-- Registration Form -->
                            <div class="login-form-container" id="registerForm" style="display: none; margin-bottom: 25px;">
                                <form action="{{ route('register') }}" method="POST" autocomplete="off">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                            </span>
                                            <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
                                            </span>
                                            <input type="email" name="email" class="form-control" placeholder="your@email.com" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                                            </span>
                                            <input type="password" name="password" class="form-control" placeholder="Create password" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                                            </span>
                                            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm password" required>
                                        </div>
                                    </div>

                                    <div class="form-footer">
                                        <button type="submit" class="btn btn-primary w-100">Create Account</button>
                                    </div>
                                </form>
                                <div class="text-center mt-4" style="margin-bottom: 10px;">
                                    <span class="text-muted">Already have an account?</span>
                                    <a href="#" class="text-primary ms-2 fw-bold" id="toggleLogin">Sign in</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    :root {
        --mint-blue: #a8e6cf;
        --primary-blue: #3a7bd5;
        --primary-gradient: linear-gradient(135deg, var(--mint-blue) 0%, var(--primary-blue) 100%);
        --auth-card-width: 1300px;  /* Increased by 20% */
        --auth-card-height: 720px;  /* Increased by 20% */
        --indicator-size: 6px;
        --font-heading: 'Inter', sans-serif;
    }

    body {
        background: var(--primary-gradient);
        min-height: 100vh;
    }

    .page-center {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .container-xl {
        max-width: var(--auth-card-width);
        width: 100%;
        padding: 0 2rem;
    }

    .auth-card {
        width: var(--auth-card-width);
        min-width: var(--auth-card-width);
        height: var(--auth-card-height);
        background: rgba(255, 255, 255, 0.98);
        border: none;
        box-shadow: 
            0 20px 40px rgba(0, 0, 0, 0.1),
            0 5px 15px rgba(0, 0, 0, 0.05);
        backdrop-filter: blur(10px);
        border-radius: 24px;
        overflow: hidden;
        position: relative;
        margin: 2rem auto;
    }

    .carousel-side {
        height: var(--auth-card-height);
        background: var(--primary-gradient);
        position: relative;
        overflow: hidden;
    }

    .welcome-header {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 100%;
        padding: 2.5rem 2rem;
        text-align: center;
        z-index: 10
    }

    .welcome-header h1 {
        font-family: var(--font-heading);
        font-size: 3.5rem;
        font-weight: 800;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        letter-spacing: -0.5px;
        margin-bottom: 1rem;
    }

    .welcome-header p {
        font-size: 1.5rem;
        font-weight: 500;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        letter-spacing: 0.5px;
        opacity: 0.9;
    }

    .carousel,
    .carousel-inner,
    .carousel-item {
        height: 100%;
    }

    .carousel-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: center;
        aspect-ratio: 4/3; /* Force aspect ratio */
    }

    .carousel-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(to bottom, 
            rgba(0,0,0,0.4) 0%, 
            rgba(0,0,0,0.2) 50%, 
            rgba(0,0,0,0.4) 100%
        );
    }

    .carousel-controls {
        position: absolute;
        bottom: 25px;
        left: 0;
        right: 0;
        z-index: 2;
    }

    .carousel-indicators {
        position: static;
        justify-content: center;
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 10px;
    }

    .carousel-indicators .indicator {
        width: var(--indicator-size);
        height: var(--indicator-size);
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.4);
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .carousel-indicators .indicator::after {
        content: '';
        position: absolute;
        top: -4px;
        left: -4px;
        right: -4px;
        bottom: -4px;
        border-radius: 50%;
        background: transparent;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        opacity: 0;
    }

    .carousel-indicators .indicator.active {
        background-color: #fff;
        transform: scale(1);
    }

    .carousel-indicators .indicator.active::after {
        opacity: 1;
    }

    .login-section {
        height: var(--auth-card-height);
        padding: 2.5rem;
        display: flex;
        flex-direction: column;
        position: relative;
    }

    .form-header {
        position: relative;
        padding-top: 1rem;
    }

    .form-header h2 {
    font-size: 2rem;
    margin-bottom: 0.5rem;
    letter-spacing: -0.5px;
    font-weight: bold !important;
    }

    .form-header p {
        font-size: 0.9rem;
        color: #6B7280;
        font-weight: lighter !important;
    }

    .navbar-brand-image {
        height: 100px;
        margin-bottom: 0px;
        object-fit: contain;
        margin-bottom: 0px !important;
    }

    .form-container {
        flex: 1;
        position: relative;
        display: flex;
        align-items: center;
    }

    .login-form-container {
        max-width: 420px;
        width: 100%;
        margin: 0 auto;
        position: absolute;
        left: 50%;
        transform: translateX(-50%);
        transition: opacity 0.3s ease;
        opacity: 0;
        visibility: hidden;
    }

    .login-form-container.active {
        opacity: 1;
        visibility: visible;
    }

    #loginForm {
        opacity: 1;
        visibility: visible;
    }

    .input-icon {
        position: relative;
    }

    .input-icon .input-icon-addon {
        position: absolute;
        top: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 2.5rem;
        color: #6c757d;
        pointer-events: none;
    }

    .input-icon .input-icon-addon:last-child {
        right: 0;
        pointer-events: auto;
    }

    .input-icon input {
        padding-left: 2.5rem;
    }

    .input-icon input + .input-icon-addon {
        left: auto;
        right: 0;
    }

    .form-control {
        height: 42px; /* Slightly reduced height */
        font-size: 0.95rem;
        border-radius: 12px;
        border: 1.5px solid rgba(230, 231, 233, 0.8);
        padding: 0.75rem 1rem;
        transition: all 0.2s ease;
    }
    .text-white-50 {
        font-weight: lighter !important;
        font-size: 1rem !important;
        color: #fff !important;
    }

    .form-control:focus {
        border-color: var(--mint-blue);
        box-shadow: 0 0 0 3px rgba(168, 230, 207, 0.25);
    }

    .btn-primary {
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(168, 230, 207, 0.4);
    }

    .btn-primary:active {
        transform: translateY(0);
    }

    .btn-primary::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.2), transparent);
        transform: translateX(-100%);
    }

    .btn-primary:hover::after {
        transform: translateX(100%);
        transition: transform 0.5s ease;
    }

    @media (max-width: 991.98px) {
        :root {
            --auth-card-width: 100%;
            --auth-card-height: 100vh;
        }

        body {
            overflow: hidden; /* Prevent body scrolling */
        }

        .page-center {
            align-items: flex-start;
            padding: 0;
            height: 100vh;
            overflow: hidden; /* Prevent page scrolling */
        }

        .container-xl {
            padding: 0;
            height: 100vh;
            overflow: hidden; /* Prevent container scrolling */
        }
        
        .auth-card {
            margin: 0;
            min-width: unset;
            width: 100%;
            height: 100vh;
            border-radius: 0;
            overflow: hidden; /* Changed from auto to hidden */
            position: relative;
        }

        .login-section {
            padding: 0 1.5rem;
            height: 100vh; /* Changed from min-height to fixed height */
            display: flex;
            flex-direction: column;
            margin-top: 120px;
            overflow-y: auto; /* Only allow scrolling here if needed */
        }

        .form-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            padding: 1rem 0.5rem;
            overflow: visible; /* Ensure no scrolling here */
        }

        .form-header {
            padding-top: 0;
            margin-bottom: 1rem !important;
        }

        .form-header.text-center {
            margin: 0 !important;
            padding: 0 !important;
        }

        .navbar-brand-image {
            height: 70px;
            margin: 0 0 0.5rem 0 !important;
        }

        .form-header h2 {
            margin-bottom: 0.25rem !important;
        }

        .form-header p {
            margin-bottom: 0 !important;
        }

        .login-form-container {
            position: relative;
            transform: none;
            left: auto;
            padding: 0;
            opacity: 1;
            visibility: visible;
            margin-top: 1rem;
        }

        .form-control {
            height: 48px;
            font-size: 16px;
        }

        .btn-primary {
            height: 48px;
        }

        .background-shapes {
            opacity: 0.3;
        }

        .carousel-side {
            display: none;
        }
    }

    @media (min-height: 800px) and (max-width: 991.98px) {
        .login-section {
            margin-top: 120px;
        }
    }

    @media (max-height: 600px) and (max-width: 991.98px) {
        .login-section {
            margin-top: 120px;
        }
    }

    .form-label {
        font-family: var(--font-heading);
        font-weight: 600;
        font-size: 0.9rem;
        color: #344767;
        margin-bottom: 0.5rem;
    }

    .text-primary {
        color: var(--primary-blue) !important;
    }

    .carousel-item {
        transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .form-control,
    .btn-primary {
        transition: all 0.3s ease;
    }

    .carousel-content,
    .services-list {
        display: none;
    }

    .background-shapes {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        overflow: hidden;
        z-index: -1;
        pointer-events: none;
    }

    .circle-1 {
        position: absolute;
        width: 900px;
        height: 900px;
        top: -25%;
        right: -15%;
        background: radial-gradient(circle, rgba(168, 230, 207, 0.2) 0%, rgba(168, 230, 207, 0) 70%);
        border-radius: 50%;
        animation: float1 25s infinite;
        z-index: 1;
    }

    .circle-2 {
        position: absolute;
        width: 700px;
        height: 700px;
        bottom: -30%;
        left: -20%;
        background: rgba(58, 123, 213, 0.15);
        border-radius: 50%;
        animation: float2 30s infinite;
        z-index: 2;
    }

    .circle-3 {
        position: absolute;
        width: 400px;
        height: 400px;
        top: 5%;
        left: -5%;
        background: rgba(168, 230, 207, 0.20);
        border-radius: 50%;
        animation: float3 20s infinite;
        z-index: 3;
    }

    .circle-4 {
        position: absolute;
        width: 450px;
        height: 450px;
        top: 10%;
        right: 5%;
        border: 40px solid rgba(58, 123, 213, 0.12);
        border-radius: 50%;
        animation: float1 10s infinite;
        z-index: 4;
        box-shadow: inset 0 0 20px rgba(58, 123, 213, 0.05);
    }

    .circle-5 {
        position: absolute;
        width: 350px;
        height: 350px;
        bottom: 5%;
        right: 8%;
        border: 40px solid rgba(168, 230, 207, 0.18);
        border-radius: 50%;
        animation: float1 25s infinite;
        z-index: 5;
        box-shadow: inset 0 0 15px rgba(168, 230, 207, 0.05);
    }

    .circle-4::after,
    .circle-5::after {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        border-radius: 50%;
        background: radial-gradient(circle at center, 
            rgba(255, 255, 255, 0.1) 0%,
            transparent 70%
        );
        pointer-events: none;
    }

    @keyframes float1 {
        0% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(-80px, 40px) rotate(8deg); }
        100% { transform: translate(0, 0) rotate(0deg); }
    }

    @keyframes float2 {
        0% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(70px, -60px) rotate(-10deg); }
        100% { transform: translate(0, 0) rotate(0deg); }
    }

    @keyframes float3 {
        0% { transform: translate(0, 0) rotate(0deg); }
        50% { transform: translate(60px, 60px) rotate(15deg); }
        100% { transform: translate(0, 0) rotate(0deg); }
    }

    @keyframes pulse1 {
        0% { transform: scale(1) rotate(0deg); opacity: 0.4; }
        50% { transform: scale(1.2) rotate(10deg); opacity: 0.7; }
        100% { transform: scale(1) rotate(0deg); opacity: 0.4; }
    }

    @keyframes pulse2 {
        0% { transform: scale(1) rotate(0deg); opacity: 0.5; }
        50% { transform: scale(1.25) rotate(-8deg); opacity: 0.8; }
        100% { transform: scale(1) rotate(0deg); opacity: 0.5; }
    }

    @media (max-width: 991.98px) {
        .circle-1, .circle-2, .circle-3, .circle-4, .circle-5 {
            opacity: 0.5;
            transform: scale(0.8);
        }
    }

    .auth-decorations {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
    }

    .auth-circle {
        position: absolute;
        border-radius: 50%;
        background: var(--primary-gradient);
        opacity: 0.1;
    }

    .auth-circle-1 {
        width: 150px;
        height: 150px;
        top: -75px;
        right: -75px;
    }

    .auth-circle-2 {
        width: 100px;
        height: 100px;
        bottom: -50px;
        left: -50px;
    }

    .login-section {
        overflow: hidden;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }

    .mb-4 {
        margin-bottom: 1.25rem !important;
    }

    /* Hide the default alert */
    .alert.alert-danger.alert-dismissible {
        display: none !important;
    }

    /* Style for the field-specific error messages */
    .invalid-feedback {
        display: block;
        color: #d63939;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        padding-left: 0.25rem;
    }

    /* Add red border to invalid inputs */
    .form-control.is-invalid {
        border-color: #d63939;
        background-image: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // Initialize tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(tooltip => {
        new bootstrap.Tooltip(tooltip);
    });
    
    // Add form submission on Enter key
    document.getElementById('loginForm').addEventListener('keypress', function(event) {
        // Check if Enter key is pressed and the event target is an input field
        if (event.key === 'Enter' && event.target.tagName.toLowerCase() === 'input') {
            event.preventDefault(); // Prevent default form submission
            
            // Find and click the submit button
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                console.log('Submitting login form...'); // Debugging log
                submitButton.click();
            }
        }
    });

    // Remove error messages on input
    document.querySelectorAll('.form-control').forEach(input => {
        input.addEventListener('input', function() {
            // Remove invalid class
            this.classList.remove('is-invalid');
            
            // Find and hide the error message
            const errorDiv = this.closest('.mb-3').querySelector('.invalid-feedback');
            if (errorDiv) {
                errorDiv.style.display = 'none';
            }
        });
    });

    // Password visibility toggle
    document.querySelector('.toggle-password').addEventListener('click', function(e) {
        e.preventDefault();
        const input = this.closest('.input-icon').querySelector('input');
        const type = input.type === 'password' ? 'text' : 'password';
        input.type = type;
        
        // Update icon based on password visibility
        this.innerHTML = type === 'password' ? 
            `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <circle cx="12" cy="12" r="2" />
                <path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
            </svg>` :
            `<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <line x1="3" y1="3" x2="21" y2="21" />
                <path d="M10.584 10.587a2 2 0 0 0 2.828 2.83" />
                <path d="M9.363 5.365a9.466 9.466 0 0 1 2.637 -.365c4 0 7.333 2.333 10 7c-.778 1.361 -1.612 2.524 -2.503 3.488m-2.14 1.861c-1.631 1.1 -3.415 1.651 -5.357 1.651c-4 0 -7.333 -2.333 -10 -7c1.369 -2.395 2.913 -4.175 4.632 -5.341" />
            </svg>`;
    });

    // Form toggle functionality
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const toggleFormBtn = document.getElementById('toggleForm');
    const toggleLoginBtn = document.getElementById('toggleLogin');
    const headerText = document.getElementById('headerText');

    function updateHeaderText(isLogin) {
        headerText.innerHTML = isLogin ? 
            `<h2 class="text-primary fw-bold mb-1">Welcome Back!</h2>
             <p class="text-muted">Please sign in to continue</p>` :
            `<h2 class="text-primary fw-bold mb-1">Create Account</h2>
             <p class="text-muted">Join us today!</p>`;
    }

    toggleFormBtn.addEventListener('click', (e) => {
        e.preventDefault();
        console.log('Toggling to registration form...'); // Debugging log
        loginForm.style.opacity = '0';
        loginForm.style.visibility = 'hidden';
        setTimeout(() => {
            updateHeaderText(false);
            registerForm.style.display = 'block';
            registerForm.style.opacity = '1';
            registerForm.style.visibility = 'visible';
            loginForm.style.display = 'none';
        }, 300);
    });

    toggleLoginBtn.addEventListener('click', (e) => {
        e.preventDefault();
        console.log('Toggling to login form...'); // Debugging log
        registerForm.style.opacity = '0';
        registerForm.style.visibility = 'hidden';
        setTimeout(() => {
            updateHeaderText(true);
            loginForm.style.display = 'block';
            loginForm.style.opacity = '1';
            loginForm.style.visibility = 'visible';
            registerForm.style.display = 'none';
        }, 300);
    });
</script>
@endpush
@endsection
