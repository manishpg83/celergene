<?php

use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminEntityController;
use App\Http\Controllers\Admin\CustomersTypeController;
use App\Http\Controllers\Admin\CountryManagerController;



Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::middleware('guest:admin')->group(function () {
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

    Route::middleware('auth:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile/update', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('profile/delete', [ProfileController::class, 'destroy'])->name('profile.delete');

        Route::post('logout', [AuthController::class, 'logout'])->name('logout');

        //Route::resource('vendors', VendorController::class);
        Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
        //Route::get('users', [UserList::class, 'index'])->name('users.index');
        Route::get('vendors/add', [VendorController::class, 'add'])->name('vendors.add');



        Route::get('entities', [AdminEntityController::class, 'index'])->name('entities.index');
        Route::get('entities/add', [AdminEntityController::class, 'add'])->name('entities.add');

        Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('customer/add', [CustomerController::class, 'add'])->name('customer.add');
        Route::get('countries', [CountryManagerController::class, 'index'])->name('countries.index');

        Route::get('customerstype', [CustomersTypeController::class, 'index'])->name('customerstype.index');
        Route::get('customerstype/add', [CustomersTypeController::class, 'add'])->name('customerstype.add');
    });
});
