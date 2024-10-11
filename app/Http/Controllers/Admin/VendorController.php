<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;


class VendorController extends Controller
{
    public function index()
    {

        return view('admin.vendors.index');
    }

    public function add()
    {
        return view('admin.vendors.add');
    }

    public function showAddVendorForm($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('livewire.admin.user.add-user', compact('vendor'));
    }

}
