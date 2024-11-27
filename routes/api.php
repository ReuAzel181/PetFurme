<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\ApiMessageController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// For the login and logout routes
Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('api.login');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('api.logout');

// Public routes
Route::post('login', [AuthenticatedSessionController::class, 'store']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('messages', [ApiMessageController::class, 'index'])->name('api.messages.index');
    Route::post('messages', [ApiMessageController::class, 'store'])->name('api.messages.store');
});

Route::get('products/', [ProductController::class, 'index'])->name('api.product.index');
