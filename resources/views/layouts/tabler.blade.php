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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
            --z-index-base: 1;
            --z-index-dropdown: 1050;
            --z-index-sticky: 1020;
            --z-index-fixed: 1030;
            --z-index-modal-backdrop: 1040;
            --z-index-modal: 1045;
            --z-index-popover: 1060;
            --z-index-tooltip: 1070;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }

        .form-control:focus {
            box-shadow: none;
        }

        /* Navbar menu styles */
        #navbar-menu {
            position: fixed;
            top: 70px; /* Height of the header */
            left: 0;
            bottom: 0; /* This ensures it takes full height */
            width: 400px;
            background-color: #3A4652;
            transition: transform 0.3s ease;
            z-index: 10000;
            overflow-y: auto; /* Allow scrolling within sidebar if needed */
        }

        #navbar-menu .navbar {
            height: 100%;
            padding: 0;
        }

        #navbar-menu .container-xl {
            height: 100%;
            background-color: #3A4652;
            padding: 0;
        }

        .sidebar-collapsed {
            transform: translateX(-100%);
        }

        /* Main content styles */
        #main-content {
            transition: margin 0.3s ease;
            margin-left: 400px;
            width: calc(100% - 400px);
            height: calc(100vh - 50px);
            overflow-y: auto;
            position: fixed;
            top: 70px;
            padding-top: 0; /* Remove top padding */
        }

        #main-content.expanded {
            margin-left: 0;
            width: 100%;
        }

        /* Smooth scrolling */
        #main-content {
            scroll-behavior: smooth;
        }

        /* Custom scrollbar */
        #main-content::-webkit-scrollbar {
            width: 8px;
        }

        #main-content::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        #main-content::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        #main-content::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Ensure content fills available space */
        .container-fluid {
            min-height: 100%;
            padding: 20px;
        }

        /* Remove conflicting styles */
        .page-wrapper {
            height: auto;
            overflow: visible;
        }

        /* Page wrapper styles */
        .page {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .page-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Container fluid styles */
        .container-fluid {
            height: 100%;
            padding: 20px;
        }

        @media (max-width: 768px) {
            #main-content {
                margin-left: 0;
                width: 100%;
            }
        }

        /* Active menu item styles */
        .navbar-nav .nav-item.active .nav-link {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-radius: 4px;
        }

        .navbar-nav .nav-link {
            color: rgba(255, 255, 255, 0.7);
            padding: 8px 16px;
            margin: 4px 0;
            transition: all 0.2s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.08);
            border-radius: 4px;
        }

        .nav-header {
            color: rgba(255, 255, 255, 0.4);
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            padding: 12px 16px 4px;
            margin-top: 8px;
        }

        .nav-link-icon {
            color: rgba(255, 255, 255, 0.7);
            margin-right: 8px;
        }

        .nav-item.active .nav-link-icon {
            color: #ffffff;
        }

        .nav-link-title {
            font-weight: 500;
        }

        /* Update main content spacing */
        .page-header {
            margin-bottom: 0.5rem; /* Reduce space after header */
            padding: 0.5rem 0; /* Reduce header padding */
        }

        .page-body {
            margin-top: 10px;
            padding-top: 0.5rem; /* Reduce top padding */
        }

        /* Header styles */
        .navbar {
            justify-content: space-around;
            position: relative !important;
            height: 70px;
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 100%;
        }

        .navbar-section {
            display: flex;
            align-items: center;
            flex: 0 0 250px;
        }

        .navbar-section-center {
            display: flex;
            align-items: center;
            justify-content: center;
            flex: 1;
            padding: 0 2rem;
            max-width: 600px;
        }

        .navbar-tools {
            display: flex;
            align-items: center;
            gap: 1rem;
            justify-content: flex-end;
        }

        .navbar-brand {
            font-size: 1.25rem;
            font-weight: 600;
            padding: 0.5rem;
            margin: 0;
            transition: all 0.2s ease;
        }

        .search-container {
            width: 100%;
            position: relative;
        }

        .user-menu {
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .user-info {
            line-height: 1.2;
        }

        /* Dark mode adjustments */
        [data-bs-theme="dark"] .navbar {
            border-color: var(--dark-border-color);
            background-color: var(--dark-bg-secondary);
        }

        [data-bs-theme="dark"] .navbar-brand {
            color: var(--dark-text-primary);
        }

        [data-bs-theme="dark"] .user-info {
            color: var(--dark-text-primary);
        }

        [data-bs-theme="dark"] .user-info .text-muted {
            color: var(--dark-text-muted) !important;
        }

        /* Quick Action Buttons */
        .btn-icon {
            width: 40px;
            height: 40px;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-primary {
            background-color: #3A4652;
            border-color: #3A4652;
        }

        .btn-primary:hover {
            background-color: #2d3741;
            border-color: #2d3741;
        }

        .btn-outline-primary {
            color: #3A4652;
            border-color: #3A4652;
        }

        .btn-outline-primary:hover {
            background-color: #3A4652;
            border-color: #3A4652;
        }

        /* User menu enhancements */
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.75rem;
        }

        /* Dropdown menu refinements */
        .dropdown-menu {
            z-index: var(--z-index-dropdown) !important;
            margin-top: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .dropdown-item {
            border-radius: 6px;
            padding: 0.5rem 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item:hover {
            background-color: rgba(58, 70, 82, 0.05);
        }

        /* Search bar styles */
        .search-form {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
        }

        .search-form .input-icon {
            width: 100%;
        }

        .form-control-rounded {
            border-radius: 20px;
            background-color: #f8f9fa;
            border: 1px solid #e9ecef;
            padding-left: 2.5rem;
            transition: all 0.2s ease;
        }

        .form-control-rounded:focus {
            background-color: #fff;
            border-color: #3A4652;
            box-shadow: 0 0 0 0.25rem rgba(58, 70, 82, 0.1);
        }

        /* Dark mode toggle styles */
        .btn-icon:hover {
            background-color: rgba(58, 70, 82, 0.1);
        }

        /* Dark mode specific styles */
        [data-bs-theme="dark"] {
            /* Background colors */
            --dark-bg-primary: #1a1d21;
            --dark-bg-secondary: #242731;
            --dark-bg-tertiary: #2f3441;
            --dark-card-bg: #242731;
            
            /* Text colors */
            --dark-text-primary: #ffffff;
            --dark-text-secondary: rgba(255, 255, 255, 0.85);
            --dark-text-muted: rgba(255, 255, 255, 0.65);
            
            /* Link colors */
            --dark-link-color: #60a5fa;
            --dark-link-hover: #93c5fd;
            
            /* Card and borders */
            --dark-border-color: rgba(255, 255, 255, 0.1);
            --dark-card-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);

            /* Apply styles */
            color: var(--dark-text-primary);
            background-color: var(--dark-bg-primary);

            /* Headers and titles */
            h1, h2, h3, h4, h5, h6,
            .card-title, .page-title {
                color: var(--dark-text-primary);
            }

            /* Card styles */
            .card {
                background-color: var(--dark-card-bg);
                border-color: var(--dark-border-color);
                box-shadow: var(--dark-card-shadow);
            }

            /* Search suggestions */
            .search-suggestions {
                background-color: var(--dark-card-bg);
                border-color: var(--dark-border-color);
                box-shadow: var(--dark-card-shadow);
            }

            .suggestion-item {
                color: var(--dark-text-primary);
                padding: 8px 12px;
                border-bottom: 1px solid var(--dark-border-color);
            }

            .suggestion-item:hover {
                background-color: var(--dark-bg-tertiary);
            }

            .suggestion-type {
                color: var(--dark-text-muted);
                background-color: var(--dark-bg-tertiary);
                padding: 2px 6px;
                border-radius: 4px;
                font-size: 0.75rem;
            }

            /* Recent activities and other text */
            .text-muted, .text-secondary {
                color: var(--dark-text-muted) !important;
            }

            .nav-header {
                color: var(--dark-text-secondary);
            }
        }

        /* Add to your existing styles */
        .search-container {
            position: relative;
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: var(--z-index-popover);
            margin-top: 0.5rem;
            background: var(--tblr-bg);
            border: 1px solid var(--tblr-border-color);
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .suggestion-item {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .suggestion-item:last-child {
            border-bottom: none;
        }

        .suggestion-type {
            display: inline-block;
            font-weight: 500;
        }

        .suggestion-text {
            flex: 1;
        }

        mark {
            background-color: rgba(96, 165, 250, 0.2);
            color: inherit;
            padding: 0 2px;
            border-radius: 2px;
        }

        [data-bs-theme="dark"] mark {
            background-color: rgba(96, 165, 250, 0.3);
        }

        /* Header layout */
        .navbar .container-xl {
            padding: 0 1.5rem;
        }

        /* Fix dropdown menus */
        .dropdown-menu {
            z-index: var(--z-index-dropdown);
            margin-top: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        /* Ensure dropdowns are visible */
        .dropdown {
            position: relative;
        }

        /* Search container */
        .search-container {
            position: relative;
            width: 100%;
        }

        /* Dark mode adjustments */
        [data-bs-theme="dark"] {
            .dropdown-menu {
                background-color: var(--dark-bg-secondary);
                border-color: var(--dark-border-color);
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
            }
            
            .search-suggestions {
                background-color: var(--dark-bg-secondary);
                border-color: var(--dark-border-color);
            }
        }

        /* Fix any calendar/datepicker dropdowns */
        .flatpickr-calendar,
        .daterangepicker {
            z-index: var(--z-index-tooltip) !important;
        }

        /* Ensure proper stacking context */
        .page {
            position: relative;
            z-index: 1;
        }

        .navbar {
            position: relative;
            z-index: 1040;
        }

        /* Space between header items */
        .header-item {
            margin: 0 0.5rem;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .navbar .container-xl {
                padding: 0 1rem;
            }
            
            .search-container {
                max-width: none;
            }
        }

        /* Header layout styles */
        .header-wrapper {
            height: 70px;
            padding: 0 16px;
        }

        .header-left, .header-right {
            flex-shrink: 0;
        }

        .header-center {
            min-width: 200px;
        }

        /* Fix calendar dropdowns */
        .flatpickr-calendar,
        .daterangepicker {
            position: absolute !important;
            z-index: 999999 !important;
        }

        /* Ensure dropdowns are visible */
        .dropdown-menu {
            position: absolute !important;
            z-index: 999999 !important;
        }

        /* Search suggestions */
        .search-suggestions {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: var(--tblr-bg);
            border: 1px solid var(--tblr-border-color);
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 999999;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .header-left, .header-right {
                flex: 0 0 200px;
            }
        }

        @media (max-width: 992px) {
            .header-center {
                margin: 0 12px;
            }
        }

        @media (max-width: 768px) {
            .header-left {
                flex: 0 0 auto;
            }
            
            .header-right {
                flex: 0 0 auto;
            }

            .header-center {
                flex: 1;
                margin: 0 8px;
            }
        }

        /* Calendar and Dropdown Fixes */
        .flatpickr-calendar,
        .daterangepicker {
            position: fixed !important;
            margin-top: 2px;
        }

        .flatpickr-calendar {
            animation: none !important;
            transition: none !important;
            transform: none !important;
        }

        /* Z-index hierarchy */
        :root {
            --z-navbar: 1030;
            --z-dropdown: 1040;
            --z-modal: 1050;
            --z-popover: 1060;
            --z-calendar: 1070;
        }

        .navbar {
            z-index: var(--z-navbar);
        }

        .dropdown-menu {
            z-index: var(--z-dropdown) !important;
        }

        .modal {
            z-index: var(--z-modal) !important;
        }

        .popover, 
        .search-suggestions {
            z-index: var(--z-popover) !important;
        }

        .flatpickr-calendar,
        .daterangepicker {
            z-index: var(--z-calendar) !important;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .navbar-section {
                flex: 0 0 200px;
            }
        }

        @media (max-width: 768px) {
            .navbar-section {
                flex: none;
            }
            
            .navbar-section-center {
                padding: 0 1rem;
            }
            
            .navbar-brand span {
                display: none;
            }
        }

        /* Remove any conflicting styles first */
        .navbar {
            position: relative !important;
            height: 70px;
        }

        /* Header Layout */
        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            height: 100%;
            padding: 0 1rem;
        }

        .header-left {
            display: flex;
            align-items: center;
            min-width: 240px;
        }

        .header-center {
            flex: 1;
            max-width: 600px;
            margin: 0 2rem;
        }

        .header-right {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            min-width: 240px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-wrapper {
            width: 100%;
            position: relative;
        }

        /* Calendar Fixes */
        .flatpickr-calendar,
        .flatpickr-months .flatpickr-month,
        .flatpickr-current-month .flatpickr-monthDropdown-months,
        .flatpickr-current-month input.cur-year {
            position: relative !important;
            z-index: 999999 !important;
        }

        .flatpickr-calendar {
            margin-top: 4px !important;
        }

        .flatpickr-calendar.open {
            display: inline-block !important;
            z-index: 999999 !important;
        }

        .flatpickr-months {
            position: relative !important;
            z-index: 999999 !important;
        }

        .flatpickr-monthDropdown-months {
            height: auto !important;
            z-index: 999999 !important;
        }

        /* Ensure dropdowns are above other elements */
        .dropdown-menu {
            z-index: 999998 !important;
        }

        /* Search suggestions */
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            z-index: 999997;
            margin-top: 4px;
        }

        /* Responsive adjustments */
        @media (max-width: 1200px) {
            .header-left, .header-right {
                min-width: 200px;
            }
            
            .header-center {
                margin: 0 1rem;
            }
        }

        @media (max-width: 768px) {
            .header-content {
                padding: 0 0.5rem;
            }
            
            .header-left {
                min-width: auto;
            }
            
            .header-center {
                margin: 0 0.5rem;
            }
            
            .header-right {
                min-width: auto;
            }
        }

        /* Add these styles to your existing CSS */
        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--tblr-bg-surface);
            border: 1px solid var(--tblr-border-color);
            border-radius: 4px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.1);
            z-index: 1000;
            max-height: 400px;
            overflow-y: auto;
        }

        .search-suggestion-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            cursor: pointer;
            border-bottom: 1px solid var(--tblr-border-color);
        }

        .search-suggestion-item:last-child {
            border-bottom: none;
        }

        .search-suggestion-item:hover {
            background-color: var(--tblr-bg-surface-secondary);
        }

        .suggestion-icon {
            width: 24px;
            margin-right: 12px;
            text-align: center;
        }

        .suggestion-content {
            flex: 1;
        }

        .suggestion-type {
            font-size: 0.75rem;
            color: var(--tblr-muted);
            margin-left: 8px;
        }

        /* Quick Action specific styles */
        .quick-action {
            background-color: var(--tblr-bg-surface-secondary);
            font-weight: 500;
        }

        .quick-action .suggestion-icon {
            font-size: 1.1em;
        }

        /* Search styles */
        .search-suggestion-item.selected {
            background-color: var(--tblr-bg-surface-secondary);
        }

        .search-input {
            padding-right: 40px;
        }

        .search-suggestions {
            margin-top: 4px;
            border-radius: 8px;
        }

        /* Dark mode adjustments for search */
        [data-bs-theme="dark"] .search-suggestions {
            background: var(--tblr-bg-surface);
            border-color: var(--tblr-border-color);
        }

        [data-bs-theme="dark"] .search-suggestion-item:hover,
        [data-bs-theme="dark"] .search-suggestion-item.selected {
            background-color: var(--tblr-bg-surface-secondary);
        }

        /* Command bar styles */
        .search-input {
            font-size: 0.95rem;
            padding-left: 2.5rem;
        }

        .search-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: var(--tblr-bg-surface);
            border: 1px solid var(--tblr-border-color);
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            margin-top: 4px;
            max-height: 400px;
            overflow-y: auto;
        }

        .search-suggestion-item {
            display: flex;
            align-items: center;
            padding: 0.75rem 1rem;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .search-suggestion-item:hover,
        .search-suggestion-item.selected {
            background-color: var(--tblr-bg-surface-secondary);
        }

        .suggestion-icon {
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            border-radius: 6px;
            background: var(--tblr-bg-surface-secondary);
        }

        .suggestion-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .suggestion-text {
            font-weight: 500;
            color: var(--tblr-body-color);
        }

        .suggestion-type {
            font-size: 0.75rem;
            color: var(--tblr-muted);
            margin-top: 2px;
        }

        /* Help items styling */
        .search-suggestion-item[data-type="Help"] {
            opacity: 0.7;
        }

        .search-suggestion-item[data-type="Help"]:hover {
            opacity: 1;
        }

        /* Dark mode adjustments */
        [data-bs-theme="dark"] .search-suggestions {
            background: var(--tblr-bg-surface);
            border-color: var(--tblr-border-color);
        }

        [data-bs-theme="dark"] .suggestion-icon {
            background: rgba(255, 255, 255, 0.1);
        }

        /* Update page header spacing */
        .page-wrapper .page-header {
            margin-top: 0 !important; /* Force margin-top to 0 */
            padding: 0.5rem 0;
        }

        /* Also ensure parent containers don't add unwanted space */
        .page-wrapper {
            margin-top: 0;
            padding-top: 0;
        }

        .page {
            margin-top: 0;
            padding-top: 0;
        }

        /* Activities container styles */
        .activities-container {
            position: relative;
            max-height: calc(100vh - 500px);
            min-height: 300px;
            overflow-y: auto;
            padding-right: 10px;
            margin-bottom: 20px;
        }

        /* Ensure the last activity item is visible */
        .activity-item:last-child {
            margin-bottom: 20px; /* Add space after last item */
        }

        /* Custom scrollbar for activities */
        .activities-container::-webkit-scrollbar {
            width: 6px;
        }

        .activities-container::-webkit-scrollbar-track {
            background: var(--tblr-bg-surface);
            border-radius: 10px;
        }

        .activities-container::-webkit-scrollbar-thumb {
            background: var(--tblr-border-color);
            border-radius: 10px;
        }

        .activities-container::-webkit-scrollbar-thumb:hover {
            background: var(--tblr-muted);
        }

        /* Container wrapper to ensure proper spacing */
        .activities-wrapper {
            position: relative;
            padding-bottom: 20px; /* Add padding at bottom */
            height: 100%;
        }

        /* Dark mode adjustments */
        [data-bs-theme="dark"] .activities-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        [data-bs-theme="dark"] .activities-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
        }
    </style>

    {{-- - Page Styles - --}}
    @stack('page-styles')
    @livewireStyles
</head>

<body>
    <script src="{{ asset('dist/js/demo-theme.min.js') }}"></script>

    <div class="page" style="overflow: hidden;">
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <div class="header-content">
                    <!-- Left Section -->
                    <div class="header-left">
                        <button class="navbar-toggler me-3" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a href="{{ route('dashboard') }}" class="navbar-brand d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M6 4h-1a2 2 0 0 0 -2 2v3.5h0a5.5 5.5 0 0 0 11 0v-3.5a2 2 0 0 0 -2 -2h-1"/>
                                <path d="M8 15a6 6 0 1 0 12 0v-3"/>
                                <path d="M11 3v2"/>
                                <path d="M6 3v2"/>
                                <path d="M20 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"/>
                            </svg>
                            <span class="ms-2">VetCare</span>
                        </a>
                    </div>

                    <!-- Center Section -->
                    <div class="header-center">
                        <div class="search-wrapper">
                            <form action="{{ route('search') }}" method="GET" class="search-form">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/>
                                            <path d="M21 21l-6 -6"/>
                                        </svg>
                                    </span>
                                    <input type="text" 
                                        value="{{ request('q') }}"
                                        class="form-control form-control-rounded search-input" 
                                        placeholder="Type a command (e.g., 'add', 'show')" 
                                        name="q" 
                                        autocomplete="off">
                                </div>
                                <div class="search-suggestions" style="display: none;"></div>
                            </form>
                        </div>
                    </div>

                    <!-- Right Section -->
                    <div class="header-right">
                        <div class="header-actions">
                            <button class="btn btn-icon btn-outline-secondary" id="theme-toggle" title="Toggle theme">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sun" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0"/>
                                    <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"/>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-moon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
                                    <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"/>
                                </svg>
                            </button>
                            
                            <!-- User Menu -->
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link d-flex lh-1 text-reset p-0 user-menu" data-bs-toggle="dropdown">
                                    <span class="avatar avatar-sm" style="background-image: url('{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('default-avatar.png') }}')"></span>
                                    <div class="d-none d-xl-block ps-2 user-info">
                                        <div class="fw-bold">{{ Auth::user()->name }}</div>
                                        <div class="mt-1 small text-muted">{{ Auth::user()->role ?? 'User' }}</div>
                                    </div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573-1.066c-1.543 .94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 001.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"/>
                                            <path d="M12 12m-3 0a3 3 0 1 0 6 0 3 3 0 0 0 -6 0"/>
                                        </svg>
                                        Account Settings
                                    </a>
                                    <form action="{{ route('logout') }}" method="post">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/>
                                                <path d="M9 12h12l-3-3"/>
                                                <path d="M18 15l3-3"/>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- here -->
        <div class="content-sd">
            <div class="collapse navbar-collapse show" id="navbar-menu">
                <div class="navbar">
                    <div class="container-xl">
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

                            <li class="nav-item {{ request()->is('notifications*') ? 'active' : null }}">
                                <a href="{{ route('notifications.index') }}" class="nav-link">
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
                                        {{ __('Notifications') }}
                                    </span>
                                </a>
                            </li>
                            
 
                            <!-- MESSAGES -->
                          
                            <li class="nav-item {{ request()->is('message*') ? 'active' : null }}">
                                <a class="nav-link" href="{{ route('messages.index') }}">
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
                            <li class="nav-item {{ request()->is('orders*') ? 'active' : null }}">
                                <a class="nav-link" href="{{ route('orders.index') }}">
                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                        <svg xmlns="http://www.w3.org/2000/svg" 
                                            class="icon icon-tabler icon-tabler-package-export" 
                                            width="24" height="24" viewBox="0 0 24 24" 
                                            stroke-width="2" stroke="currentColor" 
                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 21l-8 -4.5v-9l8 -4.5l8 4.5v4.5" />
                                            <path d="M12 12l8 -4.5" />
                                </svg>
                                    </span>
                                    <span class="nav-link-title">
                                        {{ __('Orders') }}
                                    </span>
                                </a>
                            </li>

                            @if(Auth::user()->role === 'admin')
                                <li class="nav-header">ANALYTICS</li>

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
                                <li class="nav-item {{ request()->is('pages*', 'suppliers*', 'categories*', 'units*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('pages.index') }}">
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
                                </li>

                                <!-- SETTINGS -->
                                <li class="nav-item {{ request()->is('settings*') ? 'active' : null }}">
                                    <a class="nav-link" href="{{ route('settings.index') }}">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                                                <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            {{ __('Settings') }}
                                        </span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="main-content" class="page-wrapper">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Libs JS -->
    @stack('page-libraries')
    <!-- Tabler Core -->
    <script src="{{ asset('dist/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('dist/js/demo.min.js') }}" defer></script>
    {{-- - Page Scripts - --}}
    @stack('page-scripts')

    @livewireScripts

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const navbarToggler = document.querySelector('.navbar-toggler');
        const navbarMenu = document.querySelector('#navbar-menu');
        const mainContent = document.querySelector('#main-content');
        let isCollapsed = false;

        function toggleSidebar() {
            isCollapsed = !isCollapsed;
            
            if (isCollapsed) {
                navbarMenu.classList.add('sidebar-collapsed');
                mainContent.classList.add('expanded');
            } else {
                navbarMenu.classList.remove('sidebar-collapsed');
                mainContent.classList.remove('expanded');
            }
            
            // Trigger window resize event to handle any responsive components
            window.dispatchEvent(new Event('resize'));
        }

        if (navbarToggler) {
            navbarToggler.addEventListener('click', toggleSidebar);
        }
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = themeToggle.querySelector('.icon-sun');
        const moonIcon = themeToggle.querySelector('.icon-moon');
        
        // Check for saved theme preference or default to light
        const currentTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', currentTheme);
        updateThemeIcon(currentTheme);
        
        themeToggle.addEventListener('click', function() {
            const currentTheme = document.documentElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            document.documentElement.setAttribute('data-bs-theme', newTheme);
            localStorage.setItem('theme', newTheme);
            updateThemeIcon(newTheme);
        });
        
        function updateThemeIcon(theme) {
            if (theme === 'dark') {
                sunIcon.style.display = 'none';
                moonIcon.style.display = 'block';
            } else {
                sunIcon.style.display = 'block';
                moonIcon.style.display = 'none';
            }
        }
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.querySelector('.search-input');
        const searchForm = document.querySelector('.search-form');
        const suggestionsContainer = document.querySelector('.search-suggestions');

        if (!searchInput || !suggestionsContainer) return;

        // Show quick actions on focus if input is empty
        searchInput.addEventListener('focus', function() {
            if (!this.value) {
                fetchSuggestions('');
            }
        });

        searchInput.addEventListener('keyup', function(e) {
            if (e.key === 'Enter' && !e.shiftKey) {
                e.preventDefault();
                const selectedSuggestion = document.querySelector('.search-suggestion-item.selected') || 
                                         document.querySelector('.search-suggestion-item');
                if (selectedSuggestion) {
                    window.location.href = selectedSuggestion.getAttribute('data-url');
                } else {
                    searchForm.submit();
                }
                return;
            }

            // Arrow key navigation
            if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
                e.preventDefault();
                navigateSuggestions(e.key === 'ArrowDown');
                return;
            }

            fetchSuggestions(this.value);
        });

        function fetchSuggestions(query) {
            fetch(`/search/suggestions?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach((item, index) => {
                            const div = document.createElement('div');
                            div.className = `search-suggestion-item ${item.type === 'Quick Action' ? 'quick-action' : ''}`;
                            div.setAttribute('data-url', item.url);
                            div.innerHTML = `
                                <span class="suggestion-icon">
                                    <i class="${item.icon || 'fas fa-search'}"></i>
                                </span>
                                <div class="suggestion-content">
                                    <span class="suggestion-text">${item.text}</span>
                                    <span class="suggestion-type">${item.type}</span>
                                </div>
                            `;
                            div.addEventListener('click', () => window.location.href = item.url);
                            suggestionsContainer.appendChild(div);
                        });
                        suggestionsContainer.style.display = 'block';
                    } else {
                        suggestionsContainer.style.display = 'none';
                    }
                });
        }

        function navigateSuggestions(down) {
            const suggestions = document.querySelectorAll('.search-suggestion-item');
            const current = document.querySelector('.search-suggestion-item.selected');
            let next;

            if (!current) {
                next = down ? suggestions[0] : suggestions[suggestions.length - 1];
            } else {
                const currentIndex = Array.from(suggestions).indexOf(current);
                current.classList.remove('selected');
                if (down) {
                    next = suggestions[currentIndex + 1] || suggestions[0];
                } else {
                    next = suggestions[currentIndex - 1] || suggestions[suggestions.length - 1];
                }
            }

            if (next) {
                next.classList.add('selected');
                next.scrollIntoView({ block: 'nearest' });
            }
        }

        // Close suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestionsContainer.contains(e.target)) {
                suggestionsContainer.style.display = 'none';
            }
        });
    });
    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to ensure calendar dropdowns are above other elements
        const fixCalendarDropdowns = () => {
            const monthDropdown = document.querySelector('.flatpickr-monthDropdown-months');
            const monthsElement = document.querySelector('.flatpickr-months');
            const yearInput = document.querySelector('.numInput.cur-year');
            
            if (monthDropdown) {
                monthDropdown.style.zIndex = '999999';
            }
            if (monthsElement) {
                monthsElement.style.zIndex = '999999';
            }
            if (yearInput) {
                yearInput.style.zIndex = '999999';
            }
        };

        // Watch for calendar open events
        document.addEventListener('flatpickr-calendar-open', function() {
            fixCalendarDropdowns();
            
            // Also fix after a short delay to ensure everything is rendered
            setTimeout(fixCalendarDropdowns, 100);
        });
    });
    </script>

    @stack('scripts')
</body>

</html>

