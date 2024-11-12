<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderMaster;
use App\Models\Customer;
use Illuminate\Http\Request;

class OrderMasterController extends Controller
{
    public function index()
    {
        $orders = OrderMaster::with('customer')->get();
        return view('admin.order.index', compact('orders'));
    }

    public function showOrderDetails($invoice_id)
    {
        return view('admin.order.details', ['invoice_id' => $invoice_id]);
    }

    public function add()
    {
        $customers = Customer::all();
        return view('admin.order.create', compact('customers'));
    }
}
