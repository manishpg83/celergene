<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CountryManagerController extends Controller
{
    public function index()
    {
        // Return a view that includes the Livewire component
        return view('admin.countries.index');
    }
}
