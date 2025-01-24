<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Pet Care</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
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
            height: calc(100vh - 125px);
            overflow-y: auto;
        }

        /* Hide scrollbar but allow scrolling */
        .main-content {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .main-content::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Top Navigation -->
    <nav class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50 top-nav-height safe-top">
        <div class="flex items-center justify-between px-4 h-full">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-8 w-8 text-blue-600" 
                     viewBox="0 0 24 24" 
                     fill="none" 
                     stroke="currentColor" 
                     stroke-width="2" 
                     stroke-linecap="round" 
                     stroke-linejoin="round">
                    <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1"></path>
                </svg>
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
    <main class="main-content pt-[60px] pb-[65px]">
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
    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 bottom-nav-height safe-bottom">
        <div class="flex justify-around items-center h-full">
            <a href="{{ route('pet-owner.dashboard') }}" 
               class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('pet-owner.dashboard') ? 'text-blue-600' : 'text-gray-600' }}">
                <i class="fas fa-home text-xl"></i>
                <span class="text-xs">Home</span>
            </a>
            
            <a href="{{ route('pet-owner.pets.index') }}"
               class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('pet-owner.pets.*') ? 'text-blue-600' : 'text-gray-600' }}">
                <i class="fas fa-paw text-xl"></i>
                <span class="text-xs">Pets</span>
            </a>
            
            <a href="{{ route('pet-owner.appointments.create') }}"
               class="flex flex-col items-center justify-center -mt-5">
                <div class="bg-blue-600 text-white rounded-full p-3 shadow-lg">
                    <i class="fas fa-plus text-xl"></i>
                </div>
                <span class="text-xs mt-1">Book</span>
            </a>
            
            <a href="{{ route('pet-owner.appointments.index') }}"
               class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('pet-owner.appointments.*') ? 'text-blue-600' : 'text-gray-600' }}">
                <i class="fas fa-calendar text-xl"></i>
                <span class="text-xs">Schedule</span>
            </a>
            
            <a href="{{ route('messages.index') }}"
               class="flex flex-col items-center justify-center space-y-1 {{ request()->routeIs('messages.*') ? 'text-blue-600' : 'text-gray-600' }}">
                <i class="fas fa-comments text-xl"></i>
                <span class="text-xs">Chat</span>
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
</body>
</html> 