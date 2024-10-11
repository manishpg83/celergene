<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(){
        return view('admin.customers.index');
    }

    public function add(){
        return view('admin.customers.add');
    }
    public function showAddCustomerForm($id)
    {
        $customer = Customer::findOrFail($id);
        return view('livewire.admin.customer.add-customer', compact('customers'));
    }
}
