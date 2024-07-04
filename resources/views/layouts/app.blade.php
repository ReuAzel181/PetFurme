<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'My Application')</title>
    <!-- Add your CSS files here -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Navigation bar -->
    @include('partials.navbar')
    
    <div class="container">
        @yield('content') <!-- This is where your page-specific content will go -->
    </div>
    
    <!-- Add your JavaScript files here -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
