<?php

use App\Http\Controllers\Admin\AdminEntityController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VendorController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;


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
        //Route::resource('vendors', VendorController::class);
        Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
        Route::get('vendors/add', [VendorController::class, 'add'])->name('vendors.add');


        // Entity management
        Route::get('entities', [AdminEntityController::class, 'index'])->name('entities.index');
        Route::get('entities/add', [AdminEntityController::class, 'add'])->name('entities.add');
        Route::get('entities/edit/{id}', [AdminEntityController::class, 'edit'])->name('entities.edit');
        // Customer management
        Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
    });
});
