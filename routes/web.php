<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\Auth\FrontAuthController;


Route::get('/', function () {
    return view('frontend.home');
})->name('home');
Route::get('/login',[FrontAuthController::class, 'showLoginForm'])->name('login.form'); 
Route::post('/login', [FrontAuthController::class, 'login'])->name('login');
Route::get('/register', [FrontAuthController::class, 'showRegistrationForm'])->name('frontend.register.form');
Route::post('/register', [FrontAuthController::class, 'register'])->name('frontend.register');
Route::post('/logout', [FrontAuthController::class, 'logout'])->name('logout');
Route::get('/login',[HomeController::class, 'login'])->name('login'); 
Route::get('/register',[HomeController::class, 'register'])->name('register'); 
Route::get('/myaccount',[HomeController::class, 'myaccount'])->name('myaccount'); 
Route::get('/about',[HomeController::class, 'about'])->name('about'); 
Route::get('/serum-royale',[HomeController::class, 'serumroyale'])->name('serumroyale'); 
Route::get('/energy-and-vitality',[HomeController::class, 'energyandvitality'])->name('energyandvitality'); 
Route::get('/join-pain-reduction',[HomeController::class, 'joinpainreduction'])->name('joinpainreduction'); 
Route::get('/mood-elevation',[HomeController::class, 'moodelevation'])->name('moodelevation'); 
Route::get('/stamina-and-recovery',[HomeController::class, 'staminaandrecovery'])->name('staminaandrecovery'); 
Route::get('/beauty-enhancement',[HomeController::class, 'beautyenhancement'])->name('beautyenhancement'); 
Route::get('/increase-libido',[HomeController::class, 'increaselibido'])->name('increaselibido'); 
Route::get('/lowers-glycmic-index',[HomeController::class, 'lowersglycmicindex'])->name('lowersglycmicindex'); 
Route::get('/clinical-studies',[HomeController::class, 'clinicalstudies'])->name('clinicalstudies'); 
Route::get('/celergen-reviews',[HomeController::class, 'celergenreviews'])->name('celergenreviews'); 
Route::get('/celergen-video',[HomeController::class, 'celergenvideo'])->name('celergenvideo'); 
Route::get('/celergen-features',[HomeController::class, 'celergenfeatures'])->name('celergenfeatures'); 



include __DIR__.'/admin.php';
include __DIR__.'/vendor.php';
