<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
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

    
    <?php echo $__env->yieldPushContent('page-styles'); ?>
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>

<body>
    <script src="<?php echo e(asset('dist/js/demo-theme.min.js')); ?>"></script>

    <div class="page" style="overflow: hidden;">
        <header class="navbar navbar-expand-md d-print-none" style="height: 70px">
       
            <div class="container-xl">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"
                    aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
                    <H style="margin: 0 50px 0 50px;">USER</H1>
                    <!-- <a href="<?php echo e(url('/')); ?>">
                        <img src="<?php echo e(asset('static/logo.svg')); ?>" width="110" height="32" alt="Hello"
                            class="navbar-brand-image">
                    </a> -->
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
                <div class="navbar-nav flex-row order-md-last">
                    <div class="d-none d-md-flex">

                        

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

                                <?php if(auth()->user()->unreadNotifications->count() !== 0): ?>
                                    <span class="badge bg-red"></span>
                                <?php endif; ?>
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

                        

                    </div>

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown"
                            aria-label="Open user menu">
                            <span class="avatar avatar-sm shadow-none"
                                style="background-image: url('https://example.com/path/to/static/image.jpg');">
                            </span>

                            <div class="d-none d-xl-block ps-2">
                                <div><?php echo e(Auth::user()->name); ?></div>
                                
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <a href="<?php echo e(route('profile.edit')); ?>" class="dropdown-item">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="icon dropdown-item-icon icon-tabler icon-tabler-settings" width="24"
                                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                        d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z">
                                    </path>
                                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                                </svg>
                                Account
                            </a>
                            <form action="<?php echo e(route('logout')); ?>" method="post">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="dropdown-item">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="icon dropdown-item-icon icon-tabler icon-tabler-logout" width="24"
                                        height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path
                                            d="M14 8v-2a2 2 0 0 0 -2 -2h-7a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h7a2 2 0 0 0 2 -2v-2" />
                                        <path d="M9 12h12l-3 -3" />
                                        <path d="M18 15l3 -3" />
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    


                </div>

            </div>
        </header>

        <div class="content-sd">

            <header class="navbar-expand-md">
                <div class="collapse navbar-collapse" id="navbar-menu">
                    <div class="navbar" style="padding-bottom: 0px; padding-top: 0px; height: calc(100vh - 3.5rem);">
                        <div class="container-xl" style="background-color: #3A4652; padding: 0px;">
                            <ul class="navbar-nav" style="margin: 0; position: relative; left: 70px; padding-top: 50px">

                                <li class="nav-header">MAIN</li>

                                <!-- DASHBOARD -->

                                <li class="nav-item <?php echo e(request()->is('dashboard*') ? 'active' : null); ?>">
                                    <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">
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
                                            <?php echo e(__('Dashboard')); ?>

                                        </span>
                                    </a>
                                </li>


                               <!-- NOTIFICATION -->

                                <li class="nav-item <?php echo e(request()->is('notification*') ? 'active' : null); ?>">
                                    <a class="nav-link" href="<?php echo e(route('notification')); ?>">
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
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
                                        <span class="nav-link-title" style="z-index: 1">
                                            <?php echo e(__('Notification')); ?>

                                        </span>
                                    </a>
                                </li>
                                
 
                                <!-- MESSAGES -->
                              
                                <li class="nav-item <?php echo e(request()->is('mes*') ? 'active' : null); ?>">
                                    <a class="nav-link" href="<?php echo e(route('mes.index')); ?>">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <!-- Bell Icon SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" 
                                            height="24" viewBox="0 0 24 24" stroke-width="2" 
                                            stroke="currentColor" fill="none" stroke-linecap="round" 
                                            stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 17h14m-7 -2v2m-3 -2a3 3 0 0 1 6 0a2 2 0 0 1 -2 2a2 2 0 0 1 -2 -2m-1 2a1 1 0 0 1 -2 0m-1 -3a3 3 0 0 0 6 0a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2z"/>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1">
                                            <?php echo e(__('Messages')); ?>

                                        </span>
                                    </a>
                                </li>
                                
                                <!-- APPOINTMENTS -->
                
                                <li class="nav-item <?php echo e(request()->is('appoint*') ? 'active' : null); ?>">
                                    <a class="nav-link" href="<?php echo e(route('appoint.index')); ?>">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <!-- Bell Icon SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" 
                                            height="24" viewBox="0 0 24 24" stroke-width="2" 
                                            stroke="currentColor" fill="none" stroke-linecap="round" 
                                            stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 17h14m-7 -2v2m-3 -2a3 3 0 0 1 6 0a2 2 0 0 1 -2 2a2 2 0 0 1 -2 -2m-1 2a1 1 0 0 1 -2 0m-1 -3a3 3 0 0 0 6 0a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2z"/>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            <?php echo e(__('Appointments')); ?>

                                        </span>
                                    </a>
                                </li>

                                <li class="nav-header">ADMINISTRATION</li>



                                

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"
                                        data-bs-auto-close="outside" role="button" aria-expanded="false">   
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <!-- Bell Icon SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" 
                                            height="24" viewBox="0 0 24 24" stroke-width="2" 
                                            stroke="currentColor" fill="none" stroke-linecap="round" 
                                            stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 17h14m-7 -2v2m-3 -2a3 3 0 0 1 6 0a2 2 0 0 1 -2 2a2 2 0 0 1 -2 -2m-1 2a1 1 0 0 1 -2 0m-1 -3a3 3 0 0 0 6 0a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2z"/>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            <?php echo e(__('User Management')); ?>

                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                                    <?php echo e(__('Pet Owner')); ?>

                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('orders.complete')); ?>">
                                                    <?php echo e(__('Sub Admin')); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link" href="#" onclick="return false;">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <!-- Bell Icon SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 17h14m-7 -2v2m-3 -2a3 3 0 0 1 6 0a2 2 0 0 1 -2 2a2 2 0 0 1 -2 -2m-1 2a1 1 0 0 1 -2 0m-1 -3a3 3 0 0 0 6 0a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2z"/>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title" style="z-index: 1;">
                                            <?php echo e(__('Pets')); ?>

                                        </span>
                                    </a>
                                </li>

                                

                                <li class="nav-item <?php echo e(request()->is('products*') ? 'active' : null); ?>">
                                    <a class="nav-link" href="<?php echo e(route('products.index')); ?>">
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
                                            <?php echo e(__('Products')); ?>

                                        </span>
                                    </a>
                                </li>


                                <li class="nav-item dropdown <?php echo e(request()->is('orders*') ? 'active' : null); ?>">
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
                                            <?php echo e(__('Orders')); ?>

                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                                    <?php echo e(__('All')); ?>

                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('orders.complete')); ?>">
                                                    <?php echo e(__('Completed')); ?>

                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('orders.pending')); ?>">
                                                    <?php echo e(__('Pending')); ?>

                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('due.index')); ?>">
                                                    <?php echo e(__('Due')); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>


                                <li class="nav-item dropdown <?php echo e(request()->is('purchases*') ? 'active' : null); ?>">
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
                                            <?php echo e(__('Purchases')); ?>

                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <a class="dropdown-item" href="<?php echo e(route('purchases.index')); ?>">
                                                    <?php echo e(__('All')); ?>

                                                </a>
                                                <a class="dropdown-item"
                                                    href="<?php echo e(route('purchases.approvedPurchases')); ?>">
                                                    <?php echo e(__('Approval')); ?>

                                                </a>
                                                <a class="dropdown-item"
                                                    href="<?php echo e(route('purchases.purchaseReport')); ?>">
                                                    <?php echo e(__('Daily Purchase Report')); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>



                                <li class="nav-item <?php echo e(request()->is('quotations*') ? 'active' : null); ?>">
                                    <a class="nav-link" href="<?php echo e(route('quotations.index')); ?>">
                                        <span
                                            class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
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
                                            <?php echo e(__('Quotations')); ?>

                                        </span>
                                    </a>
                                </li>

                                <li class="nav-header">REPORTS</li>


                                
                                <li class="nav-item">
                                    <a class="nav-link" href="#" onclick="return false;">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <!-- Bell Icon SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 17h14m-7 -2v2m-3 -2a3 3 0 0 1 6 0a2 2 0 0 1 -2 2a2 2 0 0 1 -2 -2m-1 2a1 1 0 0 1 -2 0m-1 -3a3 3 0 0 0 6 0a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2z"/>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            <?php echo e(__('Sales')); ?>

                                        </span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="#" onclick="return false;">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                                            <!-- Bell Icon SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                <path d="M5 17h14m-7 -2v2m-3 -2a3 3 0 0 1 6 0a2 2 0 0 1 -2 2a2 2 0 0 1 -2 -2m-1 2a1 1 0 0 1 -2 0m-1 -3a3 3 0 0 0 6 0a2 2 0 0 0 -2 -2h-2a2 2 0 0 0 -2 2z"/>
                                            </svg>
                                        </span>
                                        <span class="nav-link-title">
                                            <?php echo e(__('Appointments')); ?>

                                        </span>
                                    </a>
                                </li>

                                <li
                                    class="nav-item dropdown <?php echo e(request()->is('suppliers*', 'customers*') ? 'active' : null); ?>">
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
                                            <?php echo e(__('Pages')); ?>

                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                <a class="dropdown-item" href="<?php echo e(route('suppliers.index')); ?>">
                                                    <?php echo e(__('Suppliers')); ?>

                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('customers.index')); ?>">
                                                    <?php echo e(__('Customers')); ?>

                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </li>


                                <li
                                    class="nav-item dropdown <?php echo e(request()->is('users*', 'categories*', 'units*') ? 'active' : null); ?>">
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
                                            <?php echo e(__('Settings')); ?>

                                        </span>
                                    </a>
                                    <div class="dropdown-menu">
                                        <div class="dropdown-menu-columns">
                                            <div class="dropdown-menu-column">
                                                
                                                <a class="dropdown-item" href="<?php echo e(route('categories.index')); ?>">
                                                    <?php echo e(__('Categories')); ?>

                                                </a>
                                                <a class="dropdown-item" href="<?php echo e(route('units.index')); ?>">
                                                    <?php echo e(__('Units')); ?>

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
                    <?php echo $__env->yieldContent('content'); ?>
                </div>
                <div style="position:absolute; background-color: #3A4652; top:30px">

                </div>

                
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

</body>

</html>
<?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/layouts/tabler.blade.php ENDPATH**/ ?>