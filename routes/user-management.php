<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Add this route to handle the user-management overview page
Route::prefix('user-management')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [UserController::class, 'userManagementOverview'])->name('user-management.index');
    Route::get('/pet-owner', [UserController::class, 'petOwner'])->name('user-management.pet-owner');
    Route::get('/sub-admin', [UserController::class, 'subAdmin'])->name('user-management.sub-admin');
});
