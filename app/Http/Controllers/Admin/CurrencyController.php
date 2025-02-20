<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function index()
    {
        return view('admin.currency.index');
    }

    public function add()
    {
        return view('admin.currency.add');
    }

    public function showAddEntityForm($id)
    {
        $currency = Currency::findOrFail($id);

        return view('livewire.admin.currency.add-currency', compact('currency'));
    }
}
