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
            height: 80px; /* Increased height for better touch targets */
            display: flex;
            justify-content: space-around; /* Changed to space-around for better spacing */
            align-items: center;
            background-color: #ffffff; /* Reverted to original background color */
            border-top: 2px solid #2563eb; /* Added a thicker border for separation */
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3); /* Stronger shadow for depth */
        }

        /* Navigation items */
        .nav-item {
            position: relative;
            flex-grow: 1;
            text-align: center;
            color: #4b5563; /* Reverted to original darker gray */
            transition: color 0.3s, transform 0.3s, box-shadow 0.3s; /* Include box-shadow in transition */
            margin: 0 10px; /* Added margin for spacing */
            border-radius: 10px; /* Rounded corners for a modern look */
            padding: 10px; /* Added padding for better touch targets */
            height: 70px; /* Set fixed height */
            width: 70px; /* Set fixed width */
            display: flex; /* Flexbox for centering content */
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
            perspective: 1000px; /* Added perspective for 3D effect */
        }

        .nav-item:active {
            transform: translateY(-10px) scale(1.1); /* Move up and scale for depth */
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5); /* Stronger shadow for depth */
        }

        /* Active state */
        .nav-item.active {
            color: #2563eb; /* Original blue */
            font-weight: bold; /* Make active item bold */
            transform: translateY(-10px) scale(1.1); /* Enhanced 3D effect with higher lift */
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5); /* Stronger shadow for depth */
            background: rgb(255, 255, 255); /* Light background for active item */
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
    <nav id="bottomNav"
        class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 shadow-lg transition-all duration-300 ease-in-out">
        <div class="flex justify-around items-center h-full relative">

            <a href="{{ route('pet-owner.dashboard') }}" 
            class="nav-item flex flex-col items-center justify-center p-2 transition-all duration-300"
            data-target="home">
                <i class="fas fa-home text-xl"></i>
                <span class="text-xs">Home</span>
            </a>

            <a href="{{ route('pet-owner.pets.index') }}" 
            class="nav-item flex flex-col items-center justify-center p-2 transition-all duration-300"
            data-target="pets">
                <i class="fas fa-paw text-xl"></i>
                <span class="text-xs">Pets</span>
            </a>

            <a href="{{ route('pet-owner.appointments.index') }}" 
            class="nav-item flex flex-col items-center justify-center p-2 transition-all duration-300"
            data-target="schedule">
                <i class="fas fa-calendar text-xl"></i>
                <span class="text-xs">Schedule</span>
            </a>

            <a href="{{ route('pet-owner.messages.index') }}" 
            class="nav-item flex flex-col items-center justify-center p-2 transition-all duration-300"
            data-target="messages">
                <i class="fas fa-comments text-xl"></i>
                <span class="text-xs">Messages</span>
            </a>
        </div>
    </nav>



    <!-- Notifications Panel (Hidden by default) -->
    <div id="notifications-panel" 
         class="fixed inset-y-0 right-0 w-80 bg-white shadow-lg transform translate-x-full transition-transform duration-200 ease-in-out">
        <div class="p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Notifications</h2>
                <button onclick="toggleNotifications()" class="text-gray-500">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <!-- Add your notifications content here -->
        </div>
    </div>

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