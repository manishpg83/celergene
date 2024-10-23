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

    public function create()
    {
        $customers = Customer::all();
        return view('admin.order.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer_id' => 'required',
            'shipping_address' => 'required',
            'subtotal' => 'required',
            'discount' => 'nullable',
            'tax' => 'nullable',
            'total' => 'required',
            'remarks' => 'nullable',
            'payment_mode' => 'required',
            'invoice_status' => 'required',
        ]);

        $order = OrderMaster::create($data);
        return redirect()->route('orders.index');
    }
}
