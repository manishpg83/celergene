<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\AuthController;
use App\Http\Controllers\Vendor\DashboardController;
use App\Http\Controllers\Vendor\ProductController;

Route::group(['prefix' => 'vendor', 'as' => 'vendor.'], function () {
    // Guest routes
    Route::middleware('guest:vendor')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [AuthController::class, 'register']);
    });

    // Authenticated routes
    Route::middleware('auth:vendor')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        // Product management with permissions
        Route::group(['middleware' => ['permission:view products']], function () {
            Route::get('products', [ProductController::class, 'index'])->name('products.index');
        });

        Route::group(['middleware' => ['permission:create products']], function () {
            Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
            Route::post('products', [ProductController::class, 'store'])->name('products.store');
        });

        Route::group(['middleware' => ['permission:edit products']], function () {
            Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
            Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        });

        Route::group(['middleware' => ['permission:delete products']], function () {
            Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
        });
    });
});
