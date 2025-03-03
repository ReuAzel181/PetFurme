<?php
// index.php

// Load the Laravel application
require __DIR__.'/bootstrap/app.php';

// Handle the request
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

// Send the response to the browser
$response->send();

// Terminate the application
$kernel->terminate($request, $response); 