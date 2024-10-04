<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\AdminEntityController;

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    // Guest routes
    Route::middleware('guest:admin')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [AuthController::class, 'register']);
    });

    // Authenticated routes
    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        // Vendor management
        Route::resource('vendors', VendorController::class);

        // Entity management
        Route::get('entities', [AdminEntityController::class, 'index'])->name('entities.index');
    });
});
