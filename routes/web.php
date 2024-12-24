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
Route::get('/about',[HomeController::class, 'about'])->name('about'); 
Route::get('/serum-royale',[HomeController::class, 'serumroyale'])->name('serumroyale'); 
Route::get('/energy-and-vitality',[HomeController::class, 'energyandvitality'])->name('energyandvitality'); 




include __DIR__.'/admin.php';
include __DIR__.'/vendor.php';
