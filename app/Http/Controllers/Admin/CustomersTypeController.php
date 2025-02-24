<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerType;

class CustomersTypeController extends Controller
{
    public function index()
    {
        return view('admin.customerstype.index');
    }

    public function add()
    {
        return view('admin.customerstype.add');
    }

    public function showAddEntityForm($id)
    {
        $customerstype = CustomerType::findOrFail($id);

        return view('livewire.admin.customerstype.add-customer-type', compact('customerstype'));
    }
}
