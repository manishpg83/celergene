<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
include __DIR__.'/admin.php';
include __DIR__.'/vendor.php';
