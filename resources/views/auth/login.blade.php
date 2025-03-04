@extends('layouts.auth')

@section('content')
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <?php
        use App\Helpers\Logger; // Import the Logger class
    ?>

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
                                <?php
                                    $imagePath1 = url('storage/carousel/Carousel1.jpg');
                                    Logger::log("Loading image: $imagePath1");
                                ?>
                                <img src="{{ $imagePath1 }}" class="carousel-image" alt="Welcome" onerror="Logger::log('Image failed to load: {{ $imagePath1 }}');">
                                <div class="carousel-overlay"></div>
                            </div>
                            <div class="carousel-item">
                                <?php
                                    $imagePath2 = url('storage/carousel/Carousel2.jpg');
                                    Logger::log("Loading image: $imagePath2");
                                ?>
                                <img src="{{ $imagePath2 }}" class="carousel-image" alt="Services" onerror="Logger::log('Image failed to load: {{ $imagePath2 }}');">
                                <div class="carousel-overlay"></div>
                            </div>
                            <div class="carousel-item">
                                <?php
                                    $imagePath3 = url('storage/carousel/Carousel3.jpg');
                                    Logger::log("Loading image: $imagePath3");
                                ?>
                                <img src="{{ $imagePath3 }}" class="carousel-image" alt="Health" onerror="Logger::log('Image failed to load: {{ $imagePath3 }}');">
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
                            <img src="{{ url('storage/defaults/vc_logo.png') }}" alt="VetCare Logo" height="66" class="navbar-brand-image">
                            <div id="headerText">
                                <h2 class="text-primary fw-bold">Welcome Back!</h2>
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
                                        <button type="submit" class="btn btn-primary w-100">Log in</button>
                                    </div>
                                </form>
                                <div class="text-center mt-4" style="margin-top: 10px !important;">
                                    <span class="text-muted" style="font-size: 12px;">Don't have an account?</span>
                                    <a href="#" class="text-primary ms-2 fw-bold" id="toggleForm" style="font-size: 13px;">Create account</a>
                                </div>
                            </div>

                            <!-- Registration Form -->
                            <div class="login-form-container" id="registerForm" style="display: none; margin-bottom: 25px;">
                                    <form method="POST" action="{{ route('register') }}" id="registrationForm">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Full Name</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" /><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                                            </span>
                                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="John Doe" required>
                                        </div>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email address</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
                                            </span>
                                                <input type="email" 
                                                       name="email" 
                                                       class="form-control" 
                                                       placeholder="your@email.com" 
                                                       required>
                                        </div>
                                            <div class="invalid-feedback" style="display: none;"></div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                                            </span>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                                        </div>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Confirm Password</label>
                                        <div class="input-icon">
                                            <span class="input-icon-addon">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                                            </span>
                                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required>
                                        </div>
                                    </div>

                                        <div class="mb-3">
                                            <label class="form-check">
                                                <input type="checkbox" name="terms-of-service" class="form-check-input @error('terms-of-service') is-invalid @enderror"/>
                                                <span class="form-check-label">I agree to the Terms of Service</span>
                                            </label>
                                            @error('terms-of-service')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    <div class="form-footer">
                                            <button type="submit" class="btn btn-primary w-100" id="registerButton">Create Account</button>
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

    <!-- Update the OTP verification modal -->
    <div class="modal fade" id="otpVerificationModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold">Email Verification</h5>
                </div>
                <div class="modal-body px-4">
                    <div class="text-center mb-4">
                        <div class="verification-icon mb-3">
                            <i class="fas fa-envelope-circle-check text-primary"></i>
                        </div>
                        <h6 class="fw-bold mb-2">Check your email</h6>
                        <p class="text-muted small">We've sent a verification code to your email</p>
                    </div>
                    <form id="otpVerificationForm">
                        <div class="mb-4">
                            <label class="form-label small fw-bold mb-3">Enter 6-digit Verification Code</label>
                            <div class="otp-input-group d-flex justify-content-between gap-2">
                                <input type="text" class="form-control text-center fw-bold" maxlength="1" pattern="[0-9]" required>
                                <input type="text" class="form-control text-center fw-bold" maxlength="1" pattern="[0-9]" required>
                                <input type="text" class="form-control text-center fw-bold" maxlength="1" pattern="[0-9]" required>
                                <input type="text" class="form-control text-center fw-bold" maxlength="1" pattern="[0-9]" required>
                                <input type="text" class="form-control text-center fw-bold" maxlength="1" pattern="[0-9]" required>
                                <input type="text" class="form-control text-center fw-bold" maxlength="1" pattern="[0-9]" required>
                            </div>
                            <div class="invalid-feedback text-center"></div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 mb-3" id="verifyOtpButton">
                            Verify Code
                        </button>
                    </form>
                    <div class="text-center mt-3">
                        <p class="text-muted small mb-2">Didn't receive the code?</p>
                        <button class="btn btn-link btn-sm p-0" id="resendOtp">Resend Code</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

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
        display: none;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .is-invalid ~ .invalid-feedback {
        display: block;
    }

    .form-control.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23dc3545'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .input-icon .form-control.is-invalid {
        border-color: #dc3545;
    }

    .input-icon .form-control.is-invalid:focus {
        box-shadow: 0 0 0 0.25rem rgba(220, 53, 69, 0.25);
    }

    .alert {
        position: relative;
        padding: 1rem;
        margin-bottom: 1rem;
        border: 1px solid transparent;
        border-radius: 0.375rem;
    }

    .alert-success {
        color: #0f5132;
        background-color: #d1e7dd;
        border-color: #badbcc;
    }

    .alert-danger {
        color: #842029;
        background-color: #f8d7da;
        border-color: #f5c2c7;
    }

    .alert-dismissible {
        padding-right: 3rem;
    }

    .alert-dismissible .btn-close {
        position: absolute;
        top: 0;
        right: 0;
        padding: 1.25rem 1rem;
    }

    .fade {
        transition: opacity 0.15s linear;
    }

    .fade.show {
        opacity: 1;
    }

    .otp-input-group input {
        width: 40px;
        height: 40px;
        font-size: 1.2rem;
        text-align: center;
    }

    .modal-content {
        border-radius: 0.5rem;
    }

    .modal-header {
        border-bottom: none;
        padding-bottom: 0;
    }

    .modal-body {
        padding: 1.5rem;
    }

    /* Success Checkmark Animation */
    .success-checkmark {
        width: 80px;
        height: 80px;
        margin: 0 auto;
    }
    
    .check-icon {
        width: 80px;
        height: 80px;
        position: relative;
        border-radius: 50%;
        box-sizing: content-box;
        border: 4px solid #4CAF50;
    }
    
    .check-icon::before {
        top: 3px;
        left: -2px;
        width: 30px;
        transform-origin: 100% 50%;
        border-radius: 100px 0 0 100px;
    }
    
    .check-icon::after {
        top: 0;
        left: 30px;
        width: 60px;
        transform-origin: 0 50%;
        border-radius: 0 100px 100px 0;
        animation: rotate-circle 4.25s ease-in;
    }
    
    .icon-line {
        height: 5px;
        background-color: #4CAF50;
        display: block;
        border-radius: 2px;
        position: absolute;
        z-index: 10;
    }
    
    .icon-line.line-tip {
        top: 46px;
        left: 14px;
        width: 25px;
        transform: rotate(45deg);
        animation: icon-line-tip 0.75s;
    }
    
    .icon-line.line-long {
        top: 38px;
        right: 8px;
        width: 47px;
        transform: rotate(-45deg);
        animation: icon-line-long 0.75s;
    }
    
    .icon-circle {
        top: -4px;
        left: -4px;
        z-index: 10;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        box-sizing: content-box;
        border: 4px solid rgba(76, 175, 80, .5);
    }
    
    .icon-fix {
        top: 8px;
        width: 5px;
        left: 26px;
        z-index: 1;
        height: 85px;
        position: absolute;
        transform: rotate(-45deg);
        background-color: #fff;
    }

    /* Responsive styles for mobile */
    @media (max-width: 768px) {
        .auth-card {
            width: 100%;
            min-width: auto;
            height: auto;
            margin: 1rem;
            border-radius: 16px;
        }

        .carousel-side {
            display: none;
        }

        .modal-dialog {
            margin: 1rem;
            width: calc(100% - 2rem);
        }

        .otp-input-group {
            gap: 0.5rem !important;
        }

        .otp-input-group input {
            width: 35px;
            height: 35px;
            font-size: 1rem;
        }

        .welcome-header h1 {
            font-size: 2rem;
        }

        .welcome-header p {
            font-size: 1rem;
        }

        .form-container {
            padding: 1rem;
        }

        .login-section {
            padding: 1rem;
        }
    }

    /* Make OTP inputs more touch-friendly on mobile */
    .otp-input-group input {
        -webkit-appearance: none;
        margin: 0;
        padding: 0;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        font-weight: bold;
        color: #333;
    }

    .otp-input-group input:focus {
        border-color: #3a7bd5;
        box-shadow: 0 0 0 0.2rem rgba(58, 123, 213, 0.25);
        outline: none;
    }

    /* OTP Modal Styles */
    .verification-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto;
        background: rgba(var(--bs-primary-rgb), 0.1);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .verification-icon i {
        font-size: 2.5rem;
    }

    .otp-input-group input {
        width: 40px;
        height: 45px;
        font-size: 1.2rem;
        border-radius: 8px;
        border: 2px solid #dee2e6;
        background: #f8f9fa;
    }

    .otp-input-group input:focus {
        border-color: var(--bs-primary);
        box-shadow: 0 0 0 0.25rem rgba(var(--bs-primary-rgb), 0.25);
    }

    /* Mobile Responsive */
    @media (max-width: 576px) {
        .modal-dialog {
            margin: 1rem;
        }

        .otp-input-group {
            gap: 0.3rem !important;
        }

        .otp-input-group input {
            width: 35px;
            height: 40px;
            font-size: 1rem;
        }

        .verification-icon {
            width: 60px;
            height: 60px;
        }

        .verification-icon i {
            font-size: 2rem;
        }
    }

    /* Success Animation */
    @keyframes checkmark {
        0% {
            transform: scale(0);
            opacity: 0;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .success-animation {
        animation: checkmark 0.5s cubic-bezier(0.65, 0, 0.45, 1) forwards;
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

    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOM Content Loaded'); // Debug

        const loginForm = document.getElementById('loginForm');
        const registerForm = document.getElementById('registerForm');
        const toggleForm = document.getElementById('toggleForm');
        const toggleLogin = document.getElementById('toggleLogin');
        const registrationForm = document.getElementById('registrationForm');

        console.log('Forms found:', {
            loginForm: !!loginForm,
            registerForm: !!registerForm,
            toggleForm: !!toggleForm,
            toggleLogin: !!toggleLogin,
            registrationForm: !!registrationForm
        }); // Debug

        // Toggle between forms
        toggleForm.addEventListener('click', function(e) {
            console.log('Toggle to Register clicked'); // Debug
            e.preventDefault();
            loginForm.style.display = 'none';
            registerForm.style.display = 'block';
        });

        toggleLogin.addEventListener('click', function(e) {
            console.log('Toggle to Login clicked'); // Debug
            e.preventDefault();
            registerForm.style.display = 'none';
            loginForm.style.display = 'block';
        });

        // Handle registration form submission
        if (registrationForm) {
            registrationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitButton = this.querySelector('button[type="submit"]');
                submitButton.disabled = true;
                submitButton.innerHTML = `
                    <div class="d-flex align-items-center">
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        <span>Processing...</span>
                    </div>`;

                // Send registration request
                fetch(this.action, {
                    method: 'POST',
                    body: new FormData(this),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Show OTP modal
                        const otpModal = new bootstrap.Modal(document.getElementById('otpVerificationModal'));
                        otpModal.show();
                        
                        // Show success message
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-info text-center mb-3';
                        alert.innerHTML = `
                            <i class="fas fa-envelope me-2"></i>
                            Verification code has been sent to your email
                        `;
                        document.querySelector('.modal-body').insertBefore(alert, document.querySelector('.modal-body').firstChild);
                    } else {
                        // Show error message
                        alert(data.message || 'Registration failed. Please try again.');
                        submitButton.disabled = false;
                        submitButton.innerHTML = 'Create Account';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Create Account';
                });
            });
        }

        // Add this to clear errors when input changes
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', function() {
                const feedback = this.parentElement.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    this.classList.remove('is-invalid');
                    feedback.style.display = 'none';
                }
            });
        });

        // Show validation errors if any
        @if($errors->any())
            console.log('Validation errors:', @json($errors->all())); // Debug
            @if(old('_token') && !old('email'))
                loginForm.style.display = 'none';
                registerForm.style.display = 'block';
            @endif
        @endif
    });

    function checkEmail(input) {
        const feedback = input.nextElementSibling;
        
        fetch(`/check-email?email=${encodeURIComponent(input.value)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.exists) {
                input.classList.add('is-invalid');
                feedback.textContent = 'This email is already registered. Please login instead.';
            } else {
                input.classList.remove('is-invalid');
                feedback.textContent = '';
            }
        });
    }

    // Update the OTP verification form handler
    document.getElementById('otpVerificationForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const otpInputs = this.querySelectorAll('input');
        const otp = Array.from(otpInputs).map(input => input.value).join('');
        const verifyButton = this.querySelector('button[type="submit"]');
        const feedback = this.querySelector('.invalid-feedback');
        
        verifyButton.disabled = true;
        verifyButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Verifying...';

        fetch('/verify-otp', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ otp })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message with confetti effect
                const modal = document.getElementById('otpVerificationModal');
                const modalBody = modal.querySelector('.modal-body');
                
                // Clear existing content
                modalBody.innerHTML = `
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="success-checkmark">
                                <div class="check-icon">
                                    <span class="icon-line line-tip"></span>
                                    <span class="icon-line line-long"></span>
                                    <div class="icon-circle"></div>
                                    <div class="icon-fix"></div>
                                </div>
                            </div>
                        </div>
                        <h4 class="text-success mb-3">Account Created Successfully!</h4>
                        <p class="text-muted mb-4">Your account has been created and verified. You can now login.</p>
                        <a href="${data.redirect}" class="btn btn-primary">
                            Continue to Login
                        </a>
                    </div>
                `;

                // Add confetti effect
                startConfetti();
                
                // Redirect after 3 seconds
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 3000);
            } else {
                feedback.textContent = data.message;
                feedback.style.display = 'block';
                verifyButton.disabled = false;
                verifyButton.innerHTML = 'Verify Code';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            feedback.textContent = 'An error occurred. Please try again.';
            feedback.style.display = 'block';
            verifyButton.disabled = false;
            verifyButton.innerHTML = 'Verify Code';
        });
    });

    // Add email delivery check
    function checkEmailDelivery() {
        fetch('/check-email-delivery', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                const resendButton = document.getElementById('resendOtp');
                resendButton.disabled = false;
                resendButton.innerHTML = 'Resend Code';
                
                // Show email delivery error
                const alert = document.createElement('div');
                alert.className = 'alert alert-warning text-center mb-3';
                alert.innerHTML = `
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    Email delivery might be delayed. Click "Resend Code" if you haven't received it.
                `;
                document.querySelector('.modal-body').insertBefore(alert, document.querySelector('.modal-body').firstChild);
            }
        });
    }

    // Check email delivery after 30 seconds
    setTimeout(checkEmailDelivery, 30000);

    // Add OTP input handling
    document.querySelectorAll('.otp-input-group input').forEach((input, index) => {
        input.addEventListener('keyup', function(e) {
            if (e.key >= 0 && e.key <= 9) {
                const nextInput = this.nextElementSibling;
                if (nextInput) nextInput.focus();
            } else if (e.key === 'Backspace') {
                const prevInput = this.previousElementSibling;
                if (prevInput) prevInput.focus();
            }
        });
        
        input.addEventListener('paste', function(e) {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').split('');
            const inputs = this.parentElement.querySelectorAll('input');
            inputs.forEach((input, i) => {
                if (pastedData[i]) {
                    input.value = pastedData[i];
                    if (input.nextElementSibling) input.nextElementSibling.focus();
                }
            });
        });
    });
</script>
@endpush
