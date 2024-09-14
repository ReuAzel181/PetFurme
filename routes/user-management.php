<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Define routes under the user-management prefix
Route::prefix('user-management')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [UserController::class, 'userManagementOverview'])->name('user-management.index');
    Route::get('/pet-owner', [UserController::class, 'petOwner'])->name('user-management.pet-owner');
    Route::get('/sub-admin', [UserController::class, 'subAdmin'])->name('user-management.sub-admin');
    Route::get('/create', [UserController::class, 'create'])->name('user-management.create');
    Route::post('/store', [UserController::class, 'store'])->name('user-management.store');
});
