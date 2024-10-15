<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
   public function index()
   {
     return view('admin.warehouses.index');
   }

   public function add()
    {
        return view('admin.warehouses.add');
    }
    /* public function showAddEntityForm($id)
    {
        $customerstype = CustomerType::findOrFail($id);
        return view('livewire.admin.customerstype.add-customer-type', compact('customerstype'));
    } */
}
