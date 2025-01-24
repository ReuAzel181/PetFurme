<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }} - Pet Owner Portal</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* Mobile-first styles */
        .bottom-nav {
            position: fixed;
            bottom: 0;
            width: 100%;
            background: white;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
            display: none; /* Hidden by default, shown on mobile */
            z-index: 1000;
        }

        .bottom-nav .nav-item {
            flex: 1;
            text-align: center;
        }

        .bottom-nav .nav-link {
            padding: 0.5rem 0;
            color: #6c757d;
            display: flex;
            flex-direction: column;
            align-items: center;
            font-size: 0.8rem;
        }

        .bottom-nav .nav-link.active {
            color: #4a6cf7;
        }

        .bottom-nav .nav-link svg {
            width: 1.5rem;
            height: 1.5rem;
            margin-bottom: 0.2rem;
        }

        /* Main content padding to avoid overlap with bottom nav on mobile */
        main {
            padding-bottom: 4rem;
        }

        @media (max-width: 768px) {
            .bottom-nav {
                display: flex;
            }
            
            .top-nav {
                display: none;
            }
        }

        /* Header styles */
        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 600;
        }

        /* Card styles */
        .card {
            border-radius: 15px;
            border: none;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
            padding: 1rem 1.25rem;
        }

        /* Button styles */
        .btn-primary {
            background-color: #4a6cf7;
            border-color: #4a6cf7;
        }

        .btn-primary:hover {
            background-color: #3451b2;
            border-color: #3451b2;
        }
    </style>
</head>
<body>
    <!-- Top Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm top-nav">
        <div class="container">
            <a class="navbar-brand" href="{{ route('pet-owner.dashboard') }}">
                <img src="{{ asset('assets/img2/logo.png') }}" height="30" alt="Logo"> VetCare
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pet-owner.dashboard') ? 'active' : '' }}" 
                           href="{{ route('pet-owner.dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pet-owner.pets.*') ? 'active' : '' }}" 
                           href="{{ route('pet-owner.pets.index') }}">My Pets</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pet-owner.appointments.*') ? 'active' : '' }}" 
                           href="{{ route('pet-owner.appointments.index') }}">Appointments</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" 
                           href="{{ route('messages.index') }}">Messages</a>
                    </li>
                </ul>
                
                <div class="dropdown">
                    <a class="btn btn-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="{{ route('pet-owner.profile') }}">Profile</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Bottom Navigation for Mobile -->
    <nav class="bottom-nav">
        <a class="nav-link {{ request()->routeIs('pet-owner.dashboard') ? 'active' : '' }}" 
           href="{{ route('pet-owner.dashboard') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
            </svg>
            Home
        </a>
        <a class="nav-link {{ request()->routeIs('pet-owner.pets.*') ? 'active' : '' }}" 
           href="{{ route('pet-owner.pets.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14.7 13.5c-1.1-2-1.44-2.5-2.7-2.5s-1.74.75-2.84 2.75C8.24 15.45 6.34 15.6 5.86 17.04c-.1.27-.15.68-.14.96 0 1.18.79 2 1.8 2 1.26 0 3-1 4.5-1s3.24 1 4.5 1c1.01 0 1.8-.82 1.8-2 0-.28-.05-.7-.15-.96-.47-1.45-2.51-1.84-3.45-3.54z"/>
            </svg>
            Pets
        </a>
        <a class="nav-link {{ request()->routeIs('pet-owner.appointments.*') ? 'active' : '' }}" 
           href="{{ route('pet-owner.appointments.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="16" y1="2" x2="16" y2="6"></line>
                <line x1="8" y1="2" x2="8" y2="6"></line>
                <line x1="3" y1="10" x2="21" y2="10"></line>
            </svg>
            Appointments
        </a>
        <a class="nav-link {{ request()->routeIs('messages.*') ? 'active' : '' }}" 
           href="{{ route('messages.index') }}">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
            </svg>
            Messages
        </a>
    </nav>

    <!-- Main Content -->
    <main class="py-4">
        <div class="container">
            @if(session('status'))
                <div class="alert alert-success mb-4">
                    {{ session('status') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 