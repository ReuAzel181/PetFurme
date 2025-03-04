<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
        <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title><?php echo e(config('app.name', 'VetCare')); ?></title>
        
        <meta name="msapplication-TileColor" content="#0054a6"/>
        <meta name="theme-color" content="#0054a6"/>
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <meta name="apple-mobile-web-app-capable" content="yes"/>
        <meta name="mobile-web-app-capable" content="yes"/>
        <meta name="HandheldFriendly" content="True"/>
        <meta name="MobileOptimized" content="320"/>
        <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon"/>
        <link rel="shortcut icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon"/>
        <meta name="description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!"/>
        <meta name="canonical" content="https://tabler.io/demo/sign-in.html">
        <meta name="twitter:image:src" content="https://tabler.io/demo/static/og.png">
        <meta name="twitter:site" content="@tabler_ui">
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
        <meta name="twitter:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
        <meta property="og:image" content="https://tabler.io/demo/static/og.png">
        <meta property="og:image:width" content="1280">
        <meta property="og:image:height" content="640">
        <meta property="og:site_name" content="Tabler">
        <meta property="og:type" content="object">
        <meta property="og:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
        <meta property="og:url" content="https://tabler.io/demo/static/og.png">
        <meta property="og:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
        <!-- Preload critical assets -->
        <link rel="preload" href="<?php echo e(asset('dist/css/tabler.min.css')); ?>" as="style">
        <link rel="preload" href="<?php echo e(asset('dist/js/tabler.min.js')); ?>" as="script">
        <link rel="preload" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" as="style">
        <!-- CSS files -->
        <link href="<?php echo e(asset('dist/css/tabler.min.css')); ?>" rel="stylesheet"/>
        <link href="<?php echo e(asset('dist/css/tabler-flags.min.css')); ?>" rel="stylesheet"/>
        <link href="<?php echo e(asset('dist/css/tabler-payments.min.css')); ?>" rel="stylesheet"/>
        <link href="<?php echo e(asset('dist/css/tabler-vendors.min.css')); ?>" rel="stylesheet"/>
        <link href="<?php echo e(asset('dist/css/demo.min.css')); ?>" rel="stylesheet"/>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <style>
            :root {
                --tblr-font-sans-serif: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            }
        </style>
        <?php echo $__env->yieldPushContent('styles'); ?>
    </head>
    <body class="auth-page">
        <div class="page">
            <?php echo $__env->make('components.alert', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- Tabler Core -->
        <script src="<?php echo e(asset('dist/js/tabler.min.js')); ?>" defer></script>
        
        <!-- Add cookie consent component -->
        <?php if (isset($component)) { $__componentOriginal15be52bbad4b16aef39abc991e3ba9bd = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal15be52bbad4b16aef39abc991e3ba9bd = $attributes; } ?>
<?php $component = App\View\Components\CookieConsent::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('cookie-consent'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\CookieConsent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal15be52bbad4b16aef39abc991e3ba9bd)): ?>
<?php $attributes = $__attributesOriginal15be52bbad4b16aef39abc991e3ba9bd; ?>
<?php unset($__attributesOriginal15be52bbad4b16aef39abc991e3ba9bd); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal15be52bbad4b16aef39abc991e3ba9bd)): ?>
<?php $component = $__componentOriginal15be52bbad4b16aef39abc991e3ba9bd; ?>
<?php unset($__componentOriginal15be52bbad4b16aef39abc991e3ba9bd); ?>
<?php endif; ?>
        
        <!-- Debug script -->
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Auth page loaded');
            console.log('Cookie consent element:', document.getElementById('cookie-consent'));
            console.log('LocalStorage:', localStorage.getItem('cookieConsent'));
            console.log('Cookies:', document.cookie);
        });
        </script>
        
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>
<?php /**PATH D:\XAMPP\htdocs\PetFurme\resources\views/layouts/auth.blade.php ENDPATH**/ ?>