<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\HomeController;


Route::get('/', function () {
   /*  if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    if (Auth::guard('vendor')->check()) {
        return redirect()->route('vendor.dashboard');
    } */
    return view('frontend.home');
})->name('home');
Route::get('/login',[HomeController::class, 'login'])->name('login'); 
Route::get('/register',[HomeController::class, 'register'])->name('register'); 
Route::get('/about',[HomeController::class, 'about'])->name('about'); 
Route::get('/serum-royale',[HomeController::class, 'serumroyale'])->name('serumroyale'); 
Route::get('/energy-and-vitality',[HomeController::class, 'energyandvitality'])->name('energyandvitality'); 
Route::get('/join-pain-reduction',[HomeController::class, 'joinpainreduction'])->name('joinpainreduction'); 
Route::get('/mood-elevation',[HomeController::class, 'moodelevation'])->name('moodelevation'); 
Route::get('/stamina-and-recovery',[HomeController::class, 'staminaandrecovery'])->name('staminaandrecovery'); 
Route::get('/beauty-enhancement',[HomeController::class, 'beautyenhancement'])->name('beautyenhancement'); 
Route::get('/increase-libido',[HomeController::class, 'increaselibido'])->name('increaselibido'); 
Route::get('/lowers-glycmic-index',[HomeController::class, 'lowersglycmicindex'])->name('lowersglycmicindex'); 



include __DIR__.'/admin.php';
include __DIR__.'/vendor.php';
