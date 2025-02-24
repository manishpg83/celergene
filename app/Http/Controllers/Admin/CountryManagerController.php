<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class CountryManagerController extends Controller
{
    public function index()
    {
        return view('admin.countries.index');
    }
}
