<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    if (Auth::guard('admin')->check()) {
        return redirect()->route('admin.dashboard');
    }
    if (Auth::guard('vendor')->check()) {
        return redirect()->route('vendor.dashboard');
    }
    return view('welcome');
});
include __DIR__.'/admin.php';
include __DIR__.'/vendor.php';
