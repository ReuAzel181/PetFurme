<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    @stack('styles')
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-flags.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-payments.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/tabler-vendors.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('dist/css/demo.min.css') }}" rel="stylesheet" />
    
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .form-control:focus {
            box-shadow: none;
        }
    </style>

    {{-- - Page Styles - --}}
    @stack('page-styles')
    @livewireStyles
</head>

<body>
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>

    <div class="page" style="overflow: hidden;">
        <header class="navbar navbar-expand-md d-print-none" style="height: 70px; justify-content: center;">
       
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <H style="margin: 0 50px 0 50px;">USER</H1>

                </h1>
                <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
                    <form action="./" method="get" autocomplete="off" novalidate>
                        <div class="input-icon">
                            <span class="input-icon-addon">
                                <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" fill="none" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                    <path d="M21 21l-6 -6" />
                                </svg>
                            </span>
                            <input type="text" name="search" id="search" value=""
                                class="form-control" placeholder="Search…" aria-label="Search in website">
                        </div>
                    </form>
                </div>
                <div class="navbar-nav flex-row order-md-last" style="margin-right: 0px; margin-left: 0px;">
                    <div class="d-none d-md-flex">

                        {{-- -
                            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
                               data-bs-placement="bottom">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
                            </a>
                            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
                               data-bs-placement="bottom">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
                            </a>
                            - --}}

                        <div class="nav-item dropdown d-none d-md-flex me-3">
                            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1"
                                aria-label="Show notifications">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path
                                        d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                    <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                </svg>

                                @if (auth()->check() && optional(auth()->user()->unreadNotifications)->count() !== 0)
                                    <span class="badge bg-red"></span>
                                @endif

                            </a>
                            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">

                <!-- COMMENT MULA DITO -->
                <!-- DELETED COMMENT #2 -->
                <!-- COMMENT HANGGANG DITO -->
                 
                                <span class="dropdown-header">Dropdown header</span>
                                <a class="dropdown-item" href="#">
                                    Action
                                </a>
                                <a class="dropdown-item" href="#">
                                    Another action
                                </a>
                            </div>
                        </div>

                        {{-- -
                            <div class="dropdown">
                                <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown">Open dropdown</a>
                                <div class="dropdown-menu">
                                    <span class="dropdown-header">Dropdown header</span>
                                    <a class="dropdown-item" href="#">
                                        Action
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        Another action
                                    </a>
                                </div>
                            </div>
                            - --}}

                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                            <!-- User Avatar -->
                            <span class="avatar avatar-sm shadow-none"
                                style="background-image: url('{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('default-avatar.png') }}');">
                            </span>

                            <!-- User Info -->
                            <div class="d-none d-xl-block ps-2">
                                <div>{{ Auth::user()->name }}</div>
                                {{-- <div class="mt-1 small text-muted">UI Designer</div> --}}
                            </div>
                        </a>

                        <!-- Dropdown Menu -->
                        <div class="dropdown-menu">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                                Account
                            </a>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icon-tabler-logout" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24V24H0z" fill="none"></path>
                                        <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"></path>
                                        <path d="M9 12h12l-3 -3"></path>
                                        <path d="M18 15l3 -3"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>


                    {{-- -
                        <div class="dropdown">
                            <a href="#" class="btn dropdown-toggle" data-bs-toggle="dropdown">Open dropdown</a>
                            <div class="dropdown-menu">

                                <a class="dropdown-item" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                                        <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                    </svg>
                                    Action
                                </a>
                                <a class="dropdown-item" href="#">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon icon-tabler icon-tabler-pencil" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                        <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4"></path>
                                        <path d="M13.5 6.5l4 4"></path>
                                    </svg>
                                    Another action
                                </a>
                            </div>
                        </div>
                        - --}}


                </div>

            </div>
        </header>

        <div class="content-sd">

            <header class="navbar-expand-md">
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <div class="navbar" style="padding-bottom: 0px; padding-top: 0px; height: calc(100vh - 3.5rem);">
                        <div class="container-xl" style="background-color: #3A4652; padding: 0px;">
                            <ul class="navbar-nav" style="margin: 0; position: relative; left: 70px; padding-top: 20px">

                                <li class="nav-header">MAIN</li>

                                <!-- DASHBOARD -->

                                <li class="nav-item {{ request()->is('dashboard*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('dashboard') }}">
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                                                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            {{ __('Dashboard') }}
                                        </span>
                                    </a>
                                </li>


                                <!-- NOTIFICATION -->

                                <li class="nav-item {{ request()->is('notification*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('notification') }}">
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block">
                                            <!-- <img src="{{ asset('assets/img2/bell.png') }}" alt="Bell"> -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-bell">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 
                                                4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                                                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1">
                                            {{ __('Notification') }}
                                        </span>
                                    </a>
                                </li>
                                
 
                                <!-- MESSAGES -->
                              
                                <li class="nav-item {{ request()->is('mes*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('mes.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <!-- Bell Icon SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" 
                                            height="24" viewBox="0 0 24 24" fill="none" 
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                            stroke-linejoin="round" 
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-message-dots">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 11v.01" />
                                                <path d="M8 11v.01" />
                                                <path d="M16 11v.01" />
                                                <path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 
                                                3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3z" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1">
                                            {{ __('Messages') }}
                                        </span>
                                    </a>
                                </li>
                                
                                <!-- APPOINTMENTS -->
                
                                <li class="nav-item {{ request()->is('appointment*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('appointment.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-clock">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10.5 21h-4.5a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v3" />
                                            <path d="M16 3v4" />
                                            <path d="M8 3v4" />
                                            <path d="M4 11h10" />
                                            <path d="M18 18m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                            <path d="M18 16.5v1.5l.5 .5" />
                                        </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            {{ __('Appointment') }}
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-header">ADMINISTRATION</li>

                                <li class="nav-item {{ request()->is('user-management-index') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('user-management.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                                class="icon icon-tabler icons-tabler-outline icon-tabler-user-edit">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                                                <path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            {{ __('User Management') }}
                                        </span>
                                    </a>
                                </li>



                                <!-- PETS -->

                                <li class="nav-item {{ request()->is('pet*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('pet.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" 
                                        height="24" viewBox="0 0 24 24" fill="none" 
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                        stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-paw">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M14.7 13.5c-1.1 -2 -1.441 -2.5 -2.7 -2.5c-1.259 0 -1.736 .755 -2.836 2.747c-.942 1.703 -2.846 1.845 -3.321 3.291c-.097 .265 -.145 .677 -.143 .962c0 1.176 .787 2 1.8 2c1.259 0 3 -1 4.5 -1s3.241 1 4.5 1c1.013 0 1.8 -.823 1.8 -2c0 -.285 -.049 -.697 -.146 -.962c-.475 -1.451 -2.512 -1.835 -3.454 -3.538z" />
                                        <path d="M20.188 8.082a1.039 1.039 0 0 0 -.406 -.082h-.015c-.735 .012 -1.56 .75 -1.993 1.866c-.519 1.335 -.28 2.7 .538 3.052c.129 .055 .267 .082 .406 .082c.739 0 1.575 -.742 2.011 -1.866c.516 -1.335 .273 -2.7 -.54 -3.052z" />
                                        <path d="M9.474 9c.055 0 .109 0 .163 -.011c.944 -.128 1.533 -1.346 1.32 -2.722c-.203 -1.297 -1.047 -2.267 -1.932 -2.267c-.055 0 -.109 0 -.163 .011c-.944 .128 -1.533 1.346 -1.32 2.722c.204 1.293 1.048 2.267 1.933 2.267z" />
                                        <path d="M16.456 6.733c.214 -1.376 -.375 -2.594 -1.32 -2.722a1.164 1.164 0 0 0 -.162 -.011c-.885 0 -1.728 .97 -1.93 2.267c-.214 1.376 .375 2.594 1.32 2.722c.054 .007 .108 .011 .162 .011c.885 0 1.73 -.974 1.93 -2.267z" />
                                        <path d="M5.69 12.918c.816 -.352 1.054 -1.719 .536 -3.052c-.436 -1.124 -1.271 -1.866 -2.009 -1.866c-.14 0 -.277 .027 -.407 .082c-.816 .352 -1.054 1.719 -.536 3.052c.436 1.124 1.271 1.866 2.009 1.866c.14 0 .277 -.027 .407 -.082z" />
                                        </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            {{ __('Pets') }}
                                        </span>
                                    </a>
                                </li>

                                <!-- PRODUCT -->

                                <li class="nav-item {{ request()->is('products*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('products.index') }}">
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-packages" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                                                <path d="M2 13.5v5.5l5 3" />
                                                <path d="M7 16.545l5 -3.03" />
                                                <path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z" />
                                                <path d="M12 19l5 3" />
                                                <path d="M17 16.5l5 -3" />
                                                <path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5" />
                                                <path d="M7 5.03v5.455" />
                                                <path d="M12 8l5 -3" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            {{ __('Products') }}
                                        </span>
                                    </a>
                                </li>

                                <!-- ORDERS -->
                                <li class="nav-item dropdown {{ request()->is('orders*') ? 'active' : null }}">
                                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside" role="button" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-package-export" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 21l-8 -4.5v-9l8 -4.5l8 4.5v4.5" />
                                                <path d="M12 12l8 -4.5" />
                                                <path d="M12 12v9" />
                                                <path d="M12 12l-8 -4.5" />
                                                <path d="M15 18h7" />
                                                <path d="M19 15l3 3l-3 3" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            {{ __('Orders') }}
                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <a class="dropdown-item" href="{{ route('orders.index') }}">
                                                    {{ __('All') }}
                                                </a>
                                                <a class="dropdown-item" href="{{ route('orders.complete') }}">
                                                    {{ __('Completed') }}
                                                </a>
                                                <a class="dropdown-item" href="{{ route('orders.pending') }}">
                                                    {{ __('Pending') }}
                                                </a>
                                                <a class="dropdown-item" href="{{ route('due.index') }}">
                                                    {{ __('Due') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <!-- PURCHASES -->
                                <li class="nav-item dropdown {{ request()->is('purchases*') ? 'active' : null }}">
                                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside" role="button" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-package-import" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M12 21l-8 -4.5v-9l8 -4.5l8 4.5v4.5" />
                                                <path d="M12 12l8 -4.5" />
                                                <path d="M12 12v9" />
                                                <path d="M12 12l-8 -4.5" />
                                                <path d="M22 18h-7" />
                                                <path d="M18 15l-3 3l3 3" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            {{ __('Purchases') }}
                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <a class="dropdown-item" href="{{ route('purchases.index') }}">
                                                    {{ __('All') }}
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('purchases.approvedPurchases') }}">
                                                    {{ __('Approval') }}
                                                </a>
                                                <a class="dropdown-item"
                                                    href="{{ route('purchases.purchaseReport') }}">
                                                    {{ __('Daily Purchase Report') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>


                                <!-- QUOTATIONS -->
                                <li class="nav-item {{ request()->is('quotations*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('quotations.index') }}">
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-file" width="24" height="24"
                                                viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                                <path
                                                    d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            {{ __('Quotations') }}
                                        </span>
                                    </a>
                                </li>

                                <li class="nav-header">REPORTS</li>

                                <!-- SALES -->
                               
                                <li class="nav-item {{ request()->is('sales*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('sales.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" 
                                            height="24" viewBox="0 0 24 24" fill="none" 
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round" 
                                            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-report-money">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                                            <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                                            <path d="M14 11h-2.5a1.5 1.5 0 0 0 0 3h1a1.5 1.5 0 0 1 0 3h-2.5" />
                                            <path d="M12 17v1m0 -8v1" />
                                        </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            {{ __('Sales') }}
                                        </span>
                                    </a>
                                </li>
                                

                                <!-- PAGES -->
                                 
                                <li class="nav-item dropdown {{ request()->is('suppliers*', 'customers*') ? 'active' : null }}">
                                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside" role="button" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-layers-subtract" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M8 4m0 2a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2z" />
                                                <path d="M16 16v2a2 2 0 0 1 -2 2h-8a2 2 0 0 1 -2 -2v-8a2 2 0 0 1 2 -2h2" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            {{ __('Pages') }}
                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <a class="dropdown-item" href="{{ route('suppliers.index') }}">
                                                    {{ __('Suppliers') }}
                                                </a>
                                                <a class="dropdown-item" href="{{ route('customers.index') }}">
                                                    {{ __('Customers') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                <!-- SETTINGS -->
                                <li class="nav-item dropdown {{ request()->is('users*', 'categories*', 'units*') ? 'active' : null }}">
                                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside" role="button" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon icon-tabler icon-tabler-settings" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            {{ __('Settings') }}
                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                {{-- <a class="dropdown-item" href="{{ route('users.index') }}">
                                                        {{ __('Users') }}
                                                    </a> --}}
                                                <a class="dropdown-item" href="{{ route('categories.index') }}">
                                                    {{ __('Categories') }}
                                                </a>
                                                <a class="dropdown-item" href="{{ route('units.index') }}">
                                                    {{ __('Units') }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>


                        </div>
                    </div>
                </div>
            </header>

            <div class="page-wrapper" style="position: relative; left: 400px; padding: 0 50px;">
                <div style=" position:absolute; width: calc(100vw - 400px); padding: 0 50px; left: 0px;">
                    @yield('content')
                </div>
                <div style="position:absolute; background-color: #3A4652; top:30px">

                </div>

                {{-- <footer class="footer footer-transparent d-print-none">
                    <div class="container-xl">
                        <div class="row text-center align-items-center flex-row-reverse">
                            <div class="col-lg-auto ms-lg-auto">
                                <ul class="list-inline list-inline-dots mb-0">
                                    <li class="list-inline-item"><a href="https://tabler.io/docs" target="_blank"
                                            class="link-secondary" rel="noopener">Documentation</a></li>
                                    <li class="list-inline-item"><a href="" class="link-secondary">License</a>
                                    </li>
                                    <li class="list-inline-item"><a href="https://github.com/tabler/tabler"
                                            target="_blank" class="link-secondary" rel="noopener">Source code</a></li>
                                    <li class="list-inline-item">
                                        <a href="https://github.com/sponsors/codecalm" target="_blank"
                                            class="link-secondary" rel="noopener">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/heart -->
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="icon text-pink icon-filled icon-inline" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                    d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" />
                                            </svg>
                                            Sponsor
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                                <ul class="list-inline list-inline-dots mb-0">
                                    <li class="list-inline-item">
                                        Copyright &copy; {{ now()->year }}
                                        <a href="." class="link-secondary">Tabler</a>.
                                        All rights reserved.
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="./changelog.html" class="link-secondary" rel="noopener">
                                            v1.0.0-beta19
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="container-xl">

                    </div>
                </footer> --}}
            </div>
        </div> {{-- contentsd --}}
    </div>

    <!-- Libs JS -->
    @stack('page-libraries')
    <!-- Tabler Core -->
    <script src="{{ asset('dist/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('dist/js/demo.min.js') }}" defer></script>
    {{-- - Page Scripts - --}}
    @stack('page-scripts')

    @livewireScripts
</body>

</html>
