<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Pet Care</title>
    
    <!-- Preload critical assets -->
    <link rel="preload" href="{{ asset('fonts/Inter-Variable.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    
    <!-- Self-hosted Inter font -->
    <style>
        @font-face {
            font-family: 'Inter';
            font-weight: 100 900;
            font-display: swap;
            src: url('{{ asset('fonts/Inter-Variable.woff2') }}') format('woff2');
        }
    </style>
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" 
          integrity="sha512-..." 
          crossorigin="anonymous" 
          referrerpolicy="no-referrer" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Add Google Fonts for better typography -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        /* Custom styles for forms */
        body {
            font-family: 'Inter', sans-serif; /* Use the imported font */
            background-color: #f9fafb; /* Light background for better contrast */
        }

        /* Bottom navigation styling */
        #bottomNav {
            box-shadow: 0 -1px 0 0 rgba(0, 0, 0, 0.05);
            padding-bottom: env(safe-area-inset-bottom);
        }

        .nav-item {
            @apply relative py-2 px-3 rounded-xl transition-all duration-200;
            min-width: 64px;
        }

        .nav-icon-wrapper {
            @apply relative flex items-center justify-center w-6 h-6 mb-1;
            transition: transform 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-icon {
            @apply w-6 h-6 transition-colors duration-200;
            color: #64748b;
        }

        .nav-label {
            @apply text-xs font-medium transition-colors duration-200;
            color: #64748b;
        }

        .nav-indicator {
            @apply absolute -bottom-2 left-1/2 w-1 h-1 rounded-full transform -translate-x-1/2 transition-all duration-200 opacity-0;
            background-color: #2563eb;
        }

        /* Active & Hover States */
        .nav-item.active .nav-icon,
        .nav-item.active .nav-label {
            color: #2563eb;
        }

        .nav-item.active .nav-indicator {
            @apply opacity-100;
            width: 16px;
            height: 2px;
        }

        .nav-item.active .nav-icon-wrapper {
            transform: translateY(-2px);
        }

        .nav-item:not(.active):hover .nav-icon,
        .nav-item:not(.active):hover .nav-label {
            color: #3b82f6;
        }

        /* Safe Area Adjustments */
        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            #bottomNav {
                height: calc(4rem + env(safe-area-inset-bottom));
            }
            .nav-item {
                padding-bottom: calc(0.5rem + env(safe-area-inset-bottom));
            }
        }

        /* Navigation items */
        .nav-item {
            @apply relative flex-grow text-center transition-all duration-300 mx-2 rounded-xl py-2 px-3 h-[60px] w-[60px] flex justify-center items-center;
            color: #64748b;
        }

        .nav-item.active {
            color: #2563eb;
            font-weight: 500;
            background: #eff6ff;
        }

        .nav-item.active svg {
            @apply text-blue-600;
        }

        .nav-item:not(.active):hover {
            @apply bg-gray-50;
        }

        /* Active state */
        .nav-item:active {
            transform: translateY(-10px) scale(1.1); /* Move up and scale for depth */
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5); /* Stronger shadow for depth */
        }

        /* Hover effects */
        .nav-item:hover {
            background: rgba(0, 0, 0, 0.05); /* Light hover effect */
            transform: translateY(-5px); /* Slight lift on hover */
        }

        /* Active bubble effect */
        #activeIndicator {
            bottom: -20px; /* Adjusted position for better visibility */
            left: 0;
            width: 60px; /* Increased width for a more prominent look */
            height: 60px; /* Increased height for a more prominent look */
            background: rgba(59, 130, 246, 0.5); /* Slightly darker background for better visibility */
            border: 2px solid #2563eb; /* Added border for contrast */
            transition: all 0.3s ease-in-out;
        }


        .form-label {
            font-weight: 500; /* Medium weight for better visibility */
            margin-bottom: 0.25rem; /* Reduced margin for compactness */
            color: #333; /* Darker color for better contrast */
            font-size: 0.75rem; /* Adjusted font size for minimalism */
        }

        .form-control, .form-select {
            border-radius: 6px; /* Slightly smaller radius for a neater look */
            border: 1px solid #e4e6ef; /* Added border for better visibility */
            padding: 0.5rem 1rem; /* Reduced padding for compactness */
            margin-bottom: 0.75rem; /* Consistent spacing */
            width: 100%;
            transition: border-color 0.3s; /* Smooth transition for focus */
        }

        .form-control-lg, .form-select {
            font-size: 0.75rem; /* Set font size to smaller */
            padding: 0.5rem; /* Adjust padding if necessary */
        }

        .form-control:focus, .form-select:focus {
            border-color: #4f46e5; /* Darker blue for focus */
            box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
        }

        .required:after {
            content: " *";
            color: #dc3545;
        }

        .card {
            border: none;
            border-radius: 10px; /* Slightly smaller radius for a neater look */
            padding: 1rem; /* Reduced padding for compactness */
            margin: 1rem;
            background-color: #ffffff; /* White background for cards */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
        }

        .card-header {
            border-bottom: 1px solid #f0f0f0;
            padding: 1rem; /* Reduced padding for compactness */
            font-weight: 600; /* Bold header */
            color: #333; /* Darker color for better contrast */
        }

        .btn {
            border-radius: 6px; /* Rounded corners for buttons */
            padding: 0.5rem 1rem; /* Reduced padding for compactness */
            transition: background-color 0.3s, transform 0.2s; /* Smooth transitions */
        }
        .mb-3 {
            margin-bottom: 0px;
        }

        .mb-4 {
            margin-bottom: 0px !important;
        }

        .col-md-6.mb-3 {
            margin-bottom: 12px !important;
        }
        
        .form-control.form-control-lg {
            margin-bottom: 0px !important;
        }

        .form-footer.text-center.mt-4 {
            margin-top: 0px;
        }

        .btn-primary {
            background-color: #4f46e5; /* Primary button color */
            color: white;
        }

        .btn-primary:hover {
            background-color: #4338ca; /* Darker shade on hover */
            transform: translateY(-1px); /* Slight lift effect */
        }

        /* Custom styles for iPhone XR */
        @media only screen 
        and (device-width: 414px) 
        and (device-height: 896px) {
            .safe-top { padding-top: env(safe-area-inset-top); }
            .safe-bottom { padding-bottom: env(safe-area-inset-bottom); }
        }

        .top-nav-height {
            height: 60px;
        }

        .bottom-nav-height {
            height: 65px;
        }

        .main-content {
            padding-top: 55px;
            height: calc(100vh - 25px);
            overflow-y: auto;
            padding-bottom: 40px; 
            
        }

        /* Hide scrollbar but allow scrolling */
        .main-content {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .main-content::-webkit-scrollbar {
            display: none;
        }

        .pet-photo-upload {
            height: 100px; /* Adjust height as needed */
            width: 100px; /* Adjust width as needed */
        }
    </style>

    <!-- Modified service worker registration -->
    <script>
        if ('serviceWorker' in navigator && localStorage.getItem('cookieConsent') === 'accepted') {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registration successful');
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen overflow-hidden">
    <!-- Top Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50 top-nav-height safe-top">
        <div class="flex items-center justify-between px-4 h-full">
            <div class="flex items-center">
                <img src="{{ asset('storage/defaults/vc_logo.png') }}" 
                     alt="VetCare Logo"
                     class="h-8 w-auto">
                <span class="ml-2 font-semibold text-gray-800">VetCare</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <button class="text-gray-600" onclick="toggleNotifications()">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-3 right-10 h-2 w-2 bg-red-500 rounded-full"></span>
                </button>
                
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center space-x-2">
                        @php
                            $defaultAvatarPath = asset('storage/user_photos/no-avatar.jpg');
                            $avatarUrl = auth()->user()->photo ? 
                                asset('storage/' . auth()->user()->photo) : 
                                $defaultAvatarPath;
                        @endphp
                        
                        <img src="{{ $avatarUrl }}" 
                             alt="Profile" 
                             class="h-8 w-8 rounded-full object-cover"
                             data-fallback="{{ $defaultAvatarPath }}"
                             onError="if (!this.hasError) { this.hasError = true; this.src = this.dataset.fallback; }">
                        <i class="fas fa-chevron-down text-xs text-gray-500"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="open" 
                         @click.away="open = false"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                        <a href="{{ route('pet-owner.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-user mr-2"></i> Profile
                        </a>
                        <a href="{{ route('pet-owner.settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                            <i class="fas fa-cog mr-2"></i> Settings
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Bottom Navigation -->
    <nav id="bottomNav" class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 z-50">
        <div class="max-w-screen-sm mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <a href="{{ route('pet-owner.dashboard') }}" 
                   class="nav-item group {{ request()->routeIs('pet-owner.dashboard') ? 'active' : '' }}">
                    <div class="relative flex flex-col items-center">
                        <div class="nav-icon-wrapper">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
                                <path class="nav-icon-primary" d="M9.157 20.771v-3.066c0-.78.636-1.414 1.424-1.42h2.886c.792 0 1.433.636 1.433 1.42v3.076c0 .662.534 1.204 1.203 1.219h1.924c1.918 0 3.473-1.54 3.473-3.438v0-8.724a2.44 2.44 0 00-.962-1.905l-6.58-5.248a3.18 3.18 0 00-3.945 0L3.462 7.943A2.42 2.42 0 002.5 9.847v8.715C2.5 20.46 4.055 22 5.973 22h1.924c.685 0 1.241-.55 1.241-1.229v0" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="nav-label">Home</span>
                        <div class="nav-indicator"></div>
                    </div>
                </a>

                <a href="{{ route('pet-owner.pets.index') }}" 
                   class="nav-item group {{ request()->routeIs('pet-owner.pets.*') ? 'active' : '' }}">
                    <div class="relative flex flex-col items-center">
                        <div class="nav-icon-wrapper">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
                                <path class="nav-icon-primary" d="M4.64 15.27c0-3.56 3.88-7.14 7.75-7.14s7.75 3.58 7.75 7.14c0 1.81-.6 3.48-1.61 4.76a5.88 5.88 0 01-4.07 2.32c-.68.1-1.37.1-2.05 0a5.88 5.88 0 01-4.07-2.32 7.37 7.37 0 01-1.61-4.76z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path class="nav-icon-secondary" d="M7.65 10.23c-.55-2.96.77-5.06 3.01-5.54 2.24-.48 4.29.9 4.85 3.13M19.05 7.32c1.01 2.44.41 4.85-1.35 5.41-1.76.56-3.8-.74-4.56-2.92" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="nav-label">Pets</span>
                        <div class="nav-indicator"></div>
                    </div>
                </a>

                <a href="{{ route('pet-owner.appointments.index') }}" 
                   class="nav-item group {{ request()->routeIs('pet-owner.appointments.*') ? 'active' : '' }}">
                    <div class="relative flex flex-col items-center">
                        <div class="nav-icon-wrapper">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
                                <path class="nav-icon-primary" d="M3.093 9.404h17.814M16.442 13.31h.01M12.005 13.31h.009M7.558 13.31h.01M16.442 17.196h.01M12.005 17.196h.009M7.558 17.196h.01M16.044 2v3.29M7.965 2v3.29" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path class="nav-icon-secondary" d="M16.238 3.58H7.771C4.834 3.58 3 5.214 3 8.221v9.05C3 20.326 4.834 22 7.771 22h8.458C19.175 22 21 20.326 21 17.272V8.221c.009-3.007-1.816-4.641-4.762-4.641z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="nav-label">Schedule</span>
                        <div class="nav-indicator"></div>
                    </div>
                </a>

                <a href="{{ route('pet-owner.messages.index') }}" 
                   class="nav-item group {{ request()->routeIs('pet-owner.messages.*') ? 'active' : '' }}">
                    <div class="relative flex flex-col items-center">
                        <div class="nav-icon-wrapper">
                            <svg class="nav-icon" viewBox="0 0 24 24" fill="none">
                                <path class="nav-icon-primary" d="M17.268 9.061l-4.266 3.434a2.223 2.223 0 01-2.746 0L5.954 9.061" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path class="nav-icon-secondary" d="M6.888 3h9.428c1.36.015 2.653.59 3.58 1.59a5.017 5.017 0 011.326 3.704v6.528a5.017 5.017 0 01-1.326 3.704 4.957 4.957 0 01-3.58 1.59H6.888C3.968 20.116 2 17.741 2 14.822V8.294C2 5.375 3.968 3 6.888 3z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <span class="nav-label">Messages</span>
                        <div class="nav-indicator"></div>
                    </div>
                </a>
            </div>
        </div>
    </nav>

    <style>
        #bottomNav {
            box-shadow: 0 -1px 0 0 rgba(0, 0, 0, 0.05);
            padding-bottom: env(safe-area-inset-bottom);
        }

        .nav-item {
            @apply relative py-2 px-3 rounded-xl transition-all duration-300;
            min-width: 64px;
        }

        .nav-icon-wrapper {
            @apply relative flex items-center justify-center w-7 h-7 mb-1;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-icon {
            @apply w-7 h-7 transition-all duration-300;
            color: #64748b;
        }

        .nav-icon-primary {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-icon-secondary {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0.5;
        }

        .nav-label {
            @apply text-xs font-medium transition-all duration-300;
            color: #64748b;
            transform: translateY(0);
        }

        .nav-indicator {
            @apply absolute -bottom-2 left-1/2 w-1 h-1 rounded-full transform -translate-x-1/2 transition-all duration-300 opacity-0;
            background-color: #2563eb;
        }

        /* Active & Hover States */
        .nav-item.active .nav-icon,
        .nav-item.active .nav-label {
            color: #2563eb;
        }

        .nav-item.active .nav-icon-wrapper {
            transform: translateY(-4px) scale(1.15);
        }

        .nav-item.active .nav-label {
            transform: translateY(2px);
            font-weight: 600;
        }

        .nav-item.active .nav-indicator {
            @apply opacity-100;
            width: 20px;
            height: 3px;
            box-shadow: 0 0 8px rgba(37, 99, 235, 0.5);
        }

        .nav-item.active .nav-icon-secondary {
            opacity: 1;
        }

        /* Hover Animations */
        .nav-item:not(.active):hover .nav-icon-wrapper {
            transform: translateY(-2px);
        }

        .nav-item:not(.active):hover .nav-icon {
            color: #3b82f6;
        }

        .nav-item:not(.active):hover .nav-label {
            color: #3b82f6;
            transform: translateY(1px);
        }

        /* Animation Keyframes */
        @keyframes iconPop {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }

        @keyframes labelSlide {
            0% { transform: translateY(0); opacity: 0.5; }
            100% { transform: translateY(2px); opacity: 1; }
        }

        /* Active Animation Classes */
        .nav-item.active .nav-icon-wrapper {
            animation: iconPop 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .nav-item.active .nav-label {
            animation: labelSlide 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Safe Area Adjustments */
        @supports (padding-bottom: env(safe-area-inset-bottom)) {
            #bottomNav {
                height: calc(4rem + env(safe-area-inset-bottom));
            }
            .nav-item {
                padding-bottom: calc(0.5rem + env(safe-area-inset-bottom));
            }
        }
    </style>

    <script>
        function toggleNotifications() {
            const panel = document.getElementById('notifications-panel');
            panel.classList.toggle('translate-x-full');
        }
    </script>

    <!-- Alpine.js for dropdown -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @stack('scripts')

    {{-- Add cookie consent component --}}
    <x-cookie-consent/>

    <script>
        // Add this to debug
        console.log('Cookie consent status:', localStorage.getItem('cookieConsent'));
        console.log('Cookie consent cookie:', document.cookie.match(/cookie_consent=([^;]+)/));
    </script>

    <script>
        // Function to handle the active state
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                // Remove active class from all items
                document.querySelectorAll('.nav-item').forEach(nav => {
                    nav.classList.remove('text-blue-600', 'transform', 'translate-y-[-5px]');
                    nav.classList.add('text-gray-600');
                });
                // Add active class to the clicked item
                this.classList.add('text-blue-600', 'transform', 'translate-y-[-5px]');
                this.classList.remove('text-gray-600');
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
        const navItems = document.querySelectorAll(".nav-item");
        const indicator = document.getElementById("activeIndicator");

        function updateActiveNav() {
            let activeItem = document.querySelector(".nav-item.active");
            if (!activeItem) return;

            let rect = activeItem.getBoundingClientRect();
            let parentRect = activeItem.parentElement.getBoundingClientRect();
            indicator.style.left = `${rect.left - parentRect.left + rect.width / 2 - 25}px`;
        }

        function setActiveNav(target) {
            navItems.forEach(nav => nav.classList.remove("active"));
            let activeItem = document.querySelector(`[data-target="${target}"]`);
            if (activeItem) {
                activeItem.classList.add("active");
                updateActiveNav();
            }
        }

        // Restore from localStorage on page load
        let savedTab = localStorage.getItem("activeNav");
        if (savedTab) {
            setActiveNav(savedTab);
        } else {
            // If no saved tab, default to "home"
            setActiveNav("home");
        }

        // Add click event to update active tab
        navItems.forEach(item => {
            item.addEventListener("click", function () {
                let target = this.getAttribute("data-target");
                localStorage.setItem("activeNav", target);
                setActiveNav(target);
            });
        });

        setTimeout(updateActiveNav, 300);
    });


    </script>
</body>
</html>