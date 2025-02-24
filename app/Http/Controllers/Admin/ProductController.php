<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function add()
    {
        return view('admin.products.add');
    }

    public function showProductDetails($id)
    {
        return view('admin.products.details', ['id' => $id]);
    }
}
