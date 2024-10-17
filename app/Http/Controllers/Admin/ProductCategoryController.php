<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductCatagory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index()
    {
        return view('admin.product_catagory.index');
    }

    public function add()
    {
        return view('admin.product_catagory.add');
    }
    public function showAddEntityForm($id)
    {
        $customerstype = ProductCatagory::findOrFail($id);
        return view('livewire.admin.customerstype.add-customer-type', compact('customerstype'));
    }
}
