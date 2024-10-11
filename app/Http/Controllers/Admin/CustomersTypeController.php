<?php

namespace App\Http\Controllers\Admin;

use App\Models\CustomerType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
