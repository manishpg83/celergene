<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin\Orders\CreateOrder;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InventoryController;
use App\Http\Controllers\Admin\SuppliersController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Admin\AdminEntityController;
use App\Http\Controllers\Admin\OrderMasterController;
use App\Http\Controllers\Admin\CustomersTypeController;
use App\Http\Controllers\Admin\CountryManagerController;
use App\Http\Controllers\Admin\ProductCategoryController;



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
            Route::get('user', [VendorController::class, 'index'])->name('user.index');
            Route::get('user/add', [VendorController::class, 'add'])->name('user.add');
        });

        Route::middleware(['permission:manage entities'])->group(function () {
            Route::get('entities', [AdminEntityController::class, 'index'])->name('entities.index');
            Route::get('entities/add', [AdminEntityController::class, 'add'])->name('entities.add');
        });

        Route::middleware(['permission:manage products'])->group(function () {
            Route::get('products', [ProductController::class, 'index'])->name('products.index');
            Route::get('products/add', [ProductController::class, 'add'])->name('products.add');
        });

        Route::middleware(['permission:manage warehouses'])->group(function () {
            Route::get('warehouses', [WarehouseController::class, 'index'])->name('warehouses.index');
            Route::get('warehouses/add', [WarehouseController::class, 'add'])->name('warehouses.add');
        });

        Route::middleware(['permission:manage orders'])->group(function () {
            // Route::resource('orders', OrderMasterController::class);
            Route::get('orders/', [OrderMasterController::class, 'index'])->name('orders.index');
            Route::get('orders/add', [OrderMasterController::class, 'add'])->name('orders.add');
        });

        Route::middleware(['permission:manage product categories'])->group(function () {
            Route::get('productscategory/', [ProductCategoryController::class, 'index'])->name('productscategory.index');
            Route::get('productscategory/add', [ProductCategoryController::class, 'add'])->name('productscategory.add');
        });

        Route::middleware(['permission:manage suppliers'])->group(function () {
            Route::get('suppliers/', [SuppliersController::class, 'index'])->name('suppliers.index');
            Route::get('suppliers/add', [SuppliersController::class, 'add'])->name('suppliers.add');
        });

        Route::middleware(['permission:manage inventory'])->group(function () {
            Route::get('inventory/', [InventoryController::class, 'index'])->name('inventory.index');
            Route::get('inventory/add', [InventoryController::class, 'add'])->name('inventory.add');
        });

        Route::middleware(['permission:manage customers'])->group(function () {
            Route::get('customer', [CustomerController::class, 'index'])->name('customer.index');
            Route::get('customer/add', [CustomerController::class, 'add'])->name('customer.add');
        });

        Route::middleware(['permission:manage countries'])->group(function () {
            Route::get('countries', [CountryManagerController::class, 'index'])
                ->name('countries.index');
        });

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
