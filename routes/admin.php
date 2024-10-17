<?php

use App\Http\Controllers\Admin\AdminEntityController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CountryManagerController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomersTypeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;






Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [AuthController::class, 'login']);
        Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
        Route::post('register', [AuthController::class, 'register']);

        Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])
            ->name('password.request');
        Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])
            ->name('password.email');
        Route::get('reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])
            ->name('password.reset');
        Route::post('reset-password', [AuthController::class, 'resetPassword'])
            ->name('password.update');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])
            ->name('dashboard')
            ->middleware('permission:view dashboard');


        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        Route::middleware(['permission:manage vendors'])->group(function () {
            Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
            Route::get('vendors/add', [VendorController::class, 'add'])->name('vendors.add');
        });

        Route::middleware(['permission:manage entities'])->group(function () {
            Route::get('entities', [AdminEntityController::class, 'index'])->name('entities.index');
            Route::get('entities/add', [AdminEntityController::class, 'add'])->name('entities.add');
        });
        Route::get('warehouses', [WarehouseController::class, 'index'])->name('warehouses');
        Route::get('warehouses/add', [WarehouseController::class, 'add'])->name('warehouses.add');


        Route::middleware(['permission:manage customers'])->group(function () {
            Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
            Route::get('customer/add', [CustomerController::class, 'add'])->name('customer.add');
        });

        Route::get('countries', [CountryManagerController::class, 'index'])
            ->name('countries.index')
            ->middleware('permission:manage countries');

        Route::middleware(['permission:manage customer types'])->group(function () {
            Route::get('customerstype', [CustomersTypeController::class, 'index'])->name('customerstype.index');
            Route::get('customerstype/add', [CustomersTypeController::class, 'add'])->name('customerstype.add');
        });

        // Routes for managing roles and permissions (accessible only to super admins)
        /*  Route::middleware(['role:super-admin'])->group(function () {
            Route::resource('roles', RoleController::class);
        }); */

        Route::get('roles', [RoleController::class, 'index'])->name('roles.index')->middleware('role:super-admin');
    });
});
