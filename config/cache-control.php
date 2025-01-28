<?php

return [
    'enabled' => env('RESPONSE_CACHE_ENABLED', true),
    'ttl' => env('RESPONSE_CACHE_TTL', 5), // minutes
    'excluded_paths' => [
        'admin/*',
        'api/*',
        'login',
        'register',
        'password/*',
    ],
    'excluded_cookies' => [
        'XSRF-TOKEN',
        'laravel_session',
    ],
    'cache_headers' => env('RESPONSE_CACHE_HEADERS', true),
]; 