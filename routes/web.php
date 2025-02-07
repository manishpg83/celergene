<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\WarehouseOrderUpdate;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PayPalWebhookController;
use App\Http\Controllers\Frontend\Auth\FrontAuthController;
use App\Http\Controllers\Admin\WarehouseOrderUpdateController;

// Public routes
Route::get('/', function () {
    return view('frontend.home');
})->name('home');

Route::get('/login', [FrontAuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [FrontAuthController::class, 'login'])->name('login');
Route::get('/register', [FrontAuthController::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [FrontAuthController::class, 'register'])->name('register');
Route::post('/logout', [FrontAuthController::class, 'logout'])->name('logout');

Route::get('/warehouse/update-delivery/{delivery_order_id}', [WarehouseOrderUpdateController::class, 'edit'])
    ->name('warehouse.update.delivery.form');

Route::post('/warehouse/update-delivery/{delivery_order_id}', [WarehouseOrderUpdateController::class, 'update'])
    ->name('warehouse.update.delivery');
// Routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/myaccount', [HomeController::class, 'myAccount'])->name('myaccount');
    Route::get('/myorders', [HomeController::class, 'myOrders'])->name('myorders');
    Route::get('/orderview/{order_id?}', [HomeController::class, 'orderview'])->name('orderview');
    Route::get('/myprofile', [HomeController::class, 'myProfile'])->name('myprofile');
    Route::get('/billingaddress', [HomeController::class, 'billingaddress'])->name('billingaddress');
    Route::get('/addbillingaddress/{id?}', [HomeController::class, 'addbillingaddress'])->name('addbillingaddress');
    Route::get('/shippingaddress/{addressNumber?}', [HomeController::class, 'shippingaddress'])->name('shippingaddress');
    Route::get('/addshippingaddress', [HomeController::class, 'addshippingaddress'])->name('addshippingaddress');
    Route::post('/paypal-webhook', [PayPalWebhookController::class, 'handle'])->name('paypal.webhook');
    Route::get('/paypal/success', [PayPalWebhookController::class, 'success'])->name('paypal.success');
    Route::get('/paypal/cancel', [PayPalWebhookController::class, 'cancel'])->name('paypal.cancel');
    // Add these with your other routes
    Route::get('/checkout/error', function () {
        return view('frontend.checkout.error');
    })->name('checkout.error');

    Route::get('/checkout', function () {
        return view('frontend.checkout');
    })->name('checkout');

    Route::get('/order/success', function () {
        return view('frontend.order.success');
    })->name('order.success');

    Route::get('/addbillingaddress/{id?}', [HomeController::class, 'addbillingaddress'])->name('addbillingaddress');
    Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
    Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
});

// Other public routes
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/serum-royale', [HomeController::class, 'serumroyale'])->name('serumroyale');
Route::get('/energy-and-vitality', [HomeController::class, 'energyandvitality'])->name('energyandvitality');
Route::get('/join-pain-reduction', [HomeController::class, 'joinpainreduction'])->name('joinpainreduction');
Route::get('/mood-elevation', [HomeController::class, 'moodelevation'])->name('moodelevation');
Route::get('/stamina-and-recovery', [HomeController::class, 'staminaandrecovery'])->name('staminaandrecovery');
Route::get('/beauty-enhancement', [HomeController::class, 'beautyenhancement'])->name('beautyenhancement');
Route::get('/increase-libido', [HomeController::class, 'increaselibido'])->name('increaselibido');
Route::get('/lowers-glycmic-index', [HomeController::class, 'lowersglycmicindex'])->name('lowersglycmicindex');
Route::get('/clinical-studies', [HomeController::class, 'clinicalstudies'])->name('clinicalstudies');
Route::get('/celergen-reviews', [HomeController::class, 'celergenreviews'])->name('celergenreviews');
Route::get('/celergen-video', [HomeController::class, 'celergenvideo'])->name('celergenvideo');
Route::get('/celergen-video/{videoId}', [HomeController::class, 'celergenvideo'])->name('show.video');
Route::get('/celergen-features', [HomeController::class, 'celergenfeatures'])->name('celergenfeatures');

include __DIR__.'/admin.php';
include __DIR__.'/vendor.php';

