<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderMaster;

class OrderMasterController extends Controller
{
    public function index()
    {
        $orders = OrderMaster::with('customer')->Limit(5)->get();

        // ($orders);
        return view('admin.order.index', compact('orders'));
    }

    public function showOrderDetails($order_id)
    {
        return view('admin.order.details', ['order_id' => $order_id]);
    }

    public function orderDelivery($order_id)
    {
        return view('admin.order.order-delivery', ['order_id' => $order_id]);
    }

    public function add()
    {
        $customers = Customer::all();

        return view('admin.order.create', compact('customers'));
    }
}
