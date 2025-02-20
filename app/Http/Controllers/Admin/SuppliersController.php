<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier;

class SuppliersController extends Controller
{
    public function index()
    {
        return view('admin.suppliers.index');
    }

    public function add()
    {
        return view('admin.suppliers.add');
    }

    public function showAddEntityForm($id)
    {
        $customerstype = Supplier::findOrFail($id);

        return view('livewire.admin.customerstype.add-customer-type', compact('customerstype'));
    }
}
