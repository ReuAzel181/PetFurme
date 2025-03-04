<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>

    <?php echo $__env->yieldPushContent('styles'); ?>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name')); ?></title>

    <!-- CSS files -->
    <link href="<?php echo e(asset('dist/css/tabler.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('dist/css/tabler-flags.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('dist/css/tabler-payments.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('dist/css/tabler-vendors.min.css')); ?>" rel="stylesheet" />
    <link href="<?php echo e(asset('dist/css/demo.min.css')); ?>" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    
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
            top: 70px;
            left: 0;
            bottom: 0;
            width: 280px;
            background-color: #3A4652;
            transition: transform 0.3s ease;
            z-index: 1000;
            padding: 0;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
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
            margin-left: 280px;
            width: calc(100% - 280px);
            height: calc(100vh - 70px);
            overflow-y: auto;
            position: fixed;
            top: 70px;
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

        @media (max-width: 992px) {
            #navbar-menu {
                width: 260px;
            }
            
            #main-content {
                margin-left: 260px;
                width: calc(100% - 260px);
            }
            
            .navbar-nav .nav-item {
                margin: 2px 10px;
            }
            
            .nav-link-title {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 768px) {
            #navbar-menu {
                width: 100%;
                transform: translateX(-100%);
            }
            
            #main-content {
                margin-left: 0;
                width: 100%;
            }
            
            #navbar-menu.sidebar-collapsed {
                transform: translateX(-100%);
            }
        }

        /* Base navbar menu styles */
        #navbar-menu {
            position: fixed;
            top: 70px;
            left: 0;
            bottom: 0;
            width: 280px;
            background-color: #3A4652;
            transition: transform 0.3s ease;
            z-index: 1000;
            padding: 0;
            box-shadow: 2px 0 8px rgba(0, 0, 0, 0.1);
        }

        /* Navigation container */
        .navbar-nav {
            width: 100%;
            padding: 8px;
            display: flex;
            flex-direction: column;
            height: calc(100vh - 70px); /* Full viewport height minus header */
        }

        /* Navigation items container */
        .nav-items-container {
            display: flex;
            flex-direction: column;
            flex: 1;
            min-height: min-content; /* Ensures minimum height based on content */
        }

        /* Navigation items */
        .navbar-nav .nav-item {
            margin: 1px 0;
            width: 100%;
            flex-shrink: 0; /* Prevents items from shrinking */
        }

        /* Nav link styling */
        .navbar-nav .nav-link {
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.7);
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
            width: 100%;
            min-height: 48px; /* Minimum height instead of fixed */
            height: auto; /* Allow height to adjust */
        }

        /* Section styling */
        .nav-section {
            margin: 16px 0 4px 0;
            padding: 0 12px;
            flex-shrink: 0;
        }

        /* Content wrapper for icon and title */
        .nav-link-content {
            display: flex;
            align-items: center;
            margin-left: 20px;
            transition: margin-left 0.2s ease;
            flex: 1;
        }

        /* Icon container */
        .nav-link-icon.d-md-none.d-lg-inline-block {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            min-width: 32px;
            height: 32px;
            margin-right: 12px;
            flex-shrink: 0;
        }

        /* Active state */
        .navbar-nav .nav-item.active .nav-link {
            color: #ffffff;
            background-color: #4a5d6b;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.15);
            margin: 0 -8px;
            width: calc(100% + 16px);
        }

        .navbar-nav .nav-item.active .nav-link .nav-link-content {
            margin-left: 16px; /* Move content more to the right when active */
        }

        /* Hover effect */
        .navbar-nav .nav-link:hover .nav-link-content {
            margin-left: 12px; /* Move content slightly right on hover */
        }

        /* Icon styling */
        .nav-link-icon i {
            font-size: 1.1em;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        /* Title styling */
        .nav-link-title {
            font-size: 0.95rem;
            font-weight: 400;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
            flex: 1;
        }

        /* Active state */
        .navbar-nav .nav-item.active .nav-link .nav-link-icon {
            margin-right: 12px;
        }

        .navbar-nav .nav-item.active .nav-link .nav-link-title {
            order: 1;
        }

        /* Hover effects */
        .navbar-nav .nav-link:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.1);

        }

        /* Remove any padding from containers */
        .navbar-collapse.show,
        .navbar.navbar-light,
        #navbar-menu .navbar,
        #navbar-menu .container-xl {
            padding: 0;
        }

        /* Responsive adjustments */
        @media (max-width: 992px) {
            .nav-link-icon.d-md-none.d-lg-inline-block {
                width: 28px;
                min-width: 28px;
                height: 28px;
                margin-right: 14px;
            }
        }

        /* Update sidebar styles */
        #navbar-menu {
            padding-top: 8px;
        }

        #navbar-menu .navbar {
            padding: 0;
        }

        /* Dark mode adjustments */
        [data-bs-theme="dark"] .navbar-nav .nav-item.active {
            background-color: rgba(255, 255, 255, 0.12);
        }

        [data-bs-theme="dark"] .navbar-nav .nav-item.active .nav-link {
            background-color: #4a5d6b;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        [data-bs-theme="dark"] .nav-section-title {
            color: rgba(255, 255, 255, 0.6);
        }

        /* Remove existing conflicting styles */
        .navbar-nav .nav-link {
            margin: 0;
        }

        .nav-header {
            padding: 0;
            margin-top: 0;
        }

        /* Update main content spacing */
        .page-header {
            margin-bottom: 0.5rem;
            padding: 0.5rem 0;
        }

        .page-body {
            margin-top: 10px;
            padding-top: 0.5rem;
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
            margin-top: 0 !important;
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
            margin-bottom: 20px;
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
            padding-bottom: 20px;
            height: 100%;
        }

        /* Dark mode adjustments */
        [data-bs-theme="dark"] .activities-container::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.2);
        }

        [data-bs-theme="dark"] .activities-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
        }

        .nav-section {
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        .nav-section-header {
            padding: 0.5rem 1rem;
        }
        .nav-section-title {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            color: #6b7280;
        }

        /* Remove padding from navbar collapse and navbar-light */
        .navbar-collapse.show {
            padding: 0;
        }

        .navbar.navbar-light {
            padding: 0;
        }

        /* Adjust nav link spacing to be more compact */
        .navbar-nav .nav-item {
            margin: 1px 0;
            padding: 0 8px;
        }

        .nav-link {
            padding: 8px 12px;
        }

        /* Adjust section spacing */
        .nav-section {
            margin: 12px 0 4px 0;
            padding: 0 8px;
        }

        .nav-section-header {
            padding: 0 8px;
            margin-bottom: 4px;
        }

        /* Make nav items more compact */
        .nav-link-icon {
            margin-right: 8px;
            width: 20px;
            height: 20px;
        }

        /* Adjust title spacing */
        .nav-link-title {
            font-size: 0.9rem;
            line-height: 1.2;
        }

        /* Remove any extra padding from containers */
        #navbar-menu .container-xl,
        .navbar-collapse .container-xl {
            padding: 0;
        }

        /* Ensure proper vertical spacing for the entire nav */
        .navbar-nav {
            padding: 4px 0;
        }

        /* Remove duplicate styles */
        #navbar-menu {
            padding: 0;
        }

        #navbar-menu .navbar {
            padding: 0;
        }

        /* Update loading styles */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.75);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(2px);
        }

        .loading-overlay.active {
            display: flex;
        }

        /* Login button states */
        .btn-primary.loading {
            position: relative;
            cursor: not-allowed;
            opacity: 0.8;
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, 
                transparent 25%, transparent 50%, 
                rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, 
                transparent 75%, transparent);
            background-size: 1rem 1rem;
            animation: loading-stripes 1s linear infinite;
        }

        @keyframes loading-stripes {
            0% { background-position: 1rem 0; }
            100% { background-position: 0 0; }
        }

        .btn-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-text, 
        .btn-spinner {
            transition: all 0.2s ease;
        }

        .btn-spinner {
            display: none;
            width: 16px;
            height: 16px;
            border: 2px solid #fff;
            border-right-color: transparent;
            border-radius: 50%;
            animation: spin 0.75s linear infinite;
            margin-left: 8px;
        }

        .btn.loading .btn-text {
            opacity: 0.7;
        }

        .btn.loading .btn-spinner {
            display: inline-block;
        }

        /* Logout animation */
        .loading-content {
            text-align: center;
            padding: 2rem;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .pet-icons {
            position: relative;
            width: 100px;
            height: 100px;
            margin: 0 auto 1.5rem;
        }

        .pet-icon {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            transform: scale(0.8) translateY(10px);
            transition: all 0.3s ease;
        }

        .pet-icon.active {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        .loading-text {
            color: #3A4652;
            font-size: 1.1rem;
            font-weight: 500;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    
    <?php echo $__env->yieldPushContent('page-styles'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>

<body>
    <script src="<?php echo e(asset('dist/js/demo-theme.min.js')); ?>"></script>

    <div class="page" style="overflow: hidden;">
        <header class="navbar navbar-expand-md d-print-none">
            <div class="container-xl">
                <div class="header-content">
                    <!-- Left Section -->
                    <div class="header-left">
                        <button class="navbar-toggler me-3" type="button">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <a href="<?php echo e(route('dashboard')); ?>" class="navbar-brand d-flex align-items-center">
                            <img src="<?php echo e(asset('storage/defaults/vc_logo.png')); ?>" alt="VetCare Logo" style="height: 40px; margin-right: -5px;">
                            <span style="font-weight: bold; font-size: 1.5rem;">VetCare</span>
                        </a>
                    </div>

                    <!-- Center Section -->
                    <div class="header-center">
                        <div class="search-wrapper">
                            <form action="<?php echo e(route('search')); ?>" method="GET" class="search-form">
                                <div class="input-icon">
                                    <span class="input-icon-addon">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"/>
                                            <path d="M21 21l-6 -6"/>
                                        </svg>
                                    </span>
                                    <input type="text" 
                                        value="<?php echo e(request('q')); ?>"
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
                                    <?php if(auth()->guard()->check()): ?>
                                        <span class="avatar avatar-sm" style="background-image: url('<?php echo e(Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('assets/img2/default-avatar.png')); ?>')"></span>
                                        <div class="d-none d-xl-block ps-2 user-info">
                                            <div class="fw-bold"><?php echo e(Auth::user()->name); ?></div>
                                            <div class="mt-1 small text-muted"><?php echo e(Auth::user()->role ?? 'User'); ?></div>
                                        </div>
                                    <?php else: ?>
                                        <span class="avatar avatar-sm" style="background-image: url('<?php echo e(asset('assets/img2/default-avatar.png')); ?>')"></span>
                                        <div class="d-none d-xl-block ps-2 user-info">
                                            <div class="fw-bold">Guest</div>
                                            <div class="mt-1 small text-muted">Not logged in</div>
                                        </div>
                                    <?php endif; ?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end">
                                    <?php if(auth()->guard()->check()): ?>
                                        <a href="<?php echo e(route('profile.edit')); ?>" class="dropdown-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543-.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 0 0 -2.573-1.066c-1.543 .94-3.31-.826-2.37-2.37a1.724 1.724 0 0 0-1.065-2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 01.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"/>
                                                <path d="M12 12m-3 0a3 3 0 1 0 6 0 3 3 0 0 0 -6 0"/>
                                            </svg>
                                            Account Settings
                                        </a>
                                        <form action="<?php echo e(route('logout')); ?>" method="post">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="dropdown-item">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/>
                                                    <path d="M9 12h12l-3-3"/>
                                                    <path d="M18 15l3-3"/>
                                                </svg>
                                                Logout
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('login')); ?>" class="dropdown-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2"/>
                                                <path d="M20 12h-13l3-3m0 6l-3-3"/>
                                            </svg>
                                            Login
                                        </a>
                                        <a href="<?php echo e(route('register')); ?>" class="dropdown-item">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon dropdown-item-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/>
                                                <path d="M16 19h6"/>
                                                <path d="M19 16v6"/>
                                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4"/>
                                            </svg>
                                            Register
                                        </a>
                                    <?php endif; ?>
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
                <div class="navbar navbar-light">
                    <div class="container-xl">
                        <ul class="navbar-nav">
                            <?php if(auth()->check()): ?>
                                <?php if(auth()->user()->role === 'pet_owner'): ?>
                                    <!-- Pet Owner Navigation -->
                                    <li class="nav-item <?php echo e(request()->routeIs('pet-owner.dashboard') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('pet-owner.dashboard')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-home"></i>
                                                </span>
                                                <span class="nav-link-title">Dashboard</span>
                                            </div>
                                        </a>
                                    </li>
                                    <!-- Other pet owner menu items -->
                                <?php else: ?>
                                    <!-- HOME Section -->
                                    <li class="nav-item nav-section">
                                        <div class="nav-section-header">
                                            <span class="nav-section-title">HOME</span>
                                        </div>
                                    </li>
                                    
                                    <li class="nav-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-home"></i>
                                                </span>
                                                <span class="nav-link-title">Dashboard</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item <?php echo e(request()->routeIs('notifications.*') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('notifications.index')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-bell"></i>
                                                </span>
                                                <span class="nav-link-title">Notifications</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item <?php echo e(request()->routeIs('messages.*') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('messages.index')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-comments"></i>
                                                </span>
                                                <span class="nav-link-title">Messages</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item <?php echo e(request()->routeIs('appointment.*') || request()->routeIs('appointments.*') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('appointment.index')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                                <span class="nav-link-title">Appointments</span>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- MANAGE Section -->
                                    <li class="nav-item nav-section">
                                        <div class="nav-section-header">
                                            <span class="nav-section-title">MANAGE</span>
                                        </div>
                                    </li>

                                    <li class="nav-item <?php echo e(request()->routeIs('user-management.*') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('user-management.index')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-users"></i>
                                                </span>
                                                <span class="nav-link-title">Users</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item <?php echo e(request()->routeIs('pets.*') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('pets.index')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-paw"></i>
                                                </span>
                                                <span class="nav-link-title">Pets</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item <?php echo e(request()->routeIs('products.*') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('products.index')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-box"></i>
                                                </span>
                                                <span class="nav-link-title">Products</span>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="nav-item <?php echo e(request()->routeIs('orders.*') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('orders.index')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-shopping-cart"></i>
                                                </span>
                                                <span class="nav-link-title">Orders</span>
                                            </div>
                                        </a>
                                    </li>

                                    <!-- REPORTS Section -->
                                    <li class="nav-item nav-section">
                                        <div class="nav-section-header">
                                            <span class="nav-section-title">REPORTS</span>
                                        </div>
                                    </li>

                                    <?php if(auth()->user()->role === 'admin'): ?>
                                        <li class="nav-item <?php echo e(request()->routeIs('sales.*') ? 'active' : ''); ?>">
                                            <a class="nav-link" href="<?php echo e(route('sales.index')); ?>">
                                                <div class="nav-link-content">
                                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                        <i class="fas fa-chart-line"></i>
                                                    </span>
                                                    <span class="nav-link-title">Sales</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="nav-item <?php echo e(request()->routeIs('analytics.archives') ? 'active' : ''); ?>">
                                            <a class="nav-link" href="<?php echo e(route('analytics.archives')); ?>">
                                                <div class="nav-link-content">
                                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                        <i class="fas fa-archive"></i>
                                                    </span>
                                                    <span class="nav-link-title">Archives</span>
                                                </div>
                                            </a>
                                        </li>

                                        <li class="nav-item <?php echo e(request()->routeIs('pages.*') ? 'active' : ''); ?>">
                                            <a class="nav-link" href="<?php echo e(route('pages.index')); ?>">
                                                <div class="nav-link-content">
                                                    <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                        <i class="fas fa-file"></i>
                                                    </span>
                                                    <span class="nav-link-title">Pages</span>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endif; ?>

                                    <li class="nav-item <?php echo e(request()->routeIs('settings.*') ? 'active' : ''); ?>">
                                        <a class="nav-link" href="<?php echo e(route('settings.index')); ?>">
                                            <div class="nav-link-content">
                                                <span class="nav-link-icon d-md-none d-lg-inline-block">
                                                    <i class="fas fa-cog"></i>
                                                </span>
                                                <span class="nav-link-title">Settings</span>
                                            </div>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="main-content" class="page-wrapper">
            <div class="container-fluid">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <!-- Libs JS -->
    <?php echo $__env->yieldPushContent('page-libraries'); ?>
    <!-- Tabler Core -->
    <script src="<?php echo e(asset('dist/js/tabler.min.js')); ?>" defer></script>
    <script src="<?php echo e(asset('dist/js/demo.min.js')); ?>" defer></script>
    
    <?php echo $__env->yieldPushContent('page-scripts'); ?>

    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>


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
                                <div class="nav-link-content">
                                    <span class="suggestion-icon">
                                        <i class="${item.icon || 'fas fa-search'}"></i>
                                    </span>
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

    <div class="spinner-wrapper">
        <div class="spinner"></div>
    </div>

    <div class="loading-overlay">
        <div class="loading-content">
            <div class="pet-icons">
                <img src="<?php echo e(asset('assets/img/pets/dog.png')); ?>" class="pet-icon" alt="Dog">
                <img src="<?php echo e(asset('assets/img/pets/cat.png')); ?>" class="pet-icon" alt="Cat">
                <img src="<?php echo e(asset('assets/img/pets/bird.png')); ?>" class="pet-icon" alt="Bird">
            </div>
            <div class="loading-text">Logging out...</div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadingOverlay = document.querySelector('.loading-overlay');
        const loadingContent = document.querySelector('.loading-content');
        const petIcons = document.querySelectorAll('.pet-icon');
        let currentIcon = 0;
        let animationInterval;

        function showLoginSpinner(button) {
            button.classList.add('loading');
            button.disabled = true;
        }

        function showLogoutContent() {
            loadingOverlay.classList.add('active');
            loadingContent.classList.add('active');
            startPetAnimation();
        }

        function startPetAnimation() {
            petIcons[currentIcon].classList.add('active');
            animationInterval = setInterval(() => {
                petIcons[currentIcon].classList.remove('active');
                currentIcon = (currentIcon + 1) % petIcons.length;
                petIcons[currentIcon].classList.add('active');
            }, 500);
        }

        // Login form handler
        const loginForm = document.querySelector('form[action*="login"]');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const submitButton = this.querySelector('button[type="submit"]');
                showLoginSpinner(submitButton);
                setTimeout(() => {
                    this.submit();
                }, 100);
            });
        }

        // Logout form handler
        const logoutForm = document.querySelector('form[action*="logout"]');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                e.preventDefault();
                showLogoutContent();
                setTimeout(() => {
                    this.submit();
                }, 100);
            });
        }
    });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>

<?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/layouts/tabler.blade.php ENDPATH**/ ?>