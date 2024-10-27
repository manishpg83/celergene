<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalOrders = OrderMaster::count();
        $averageOrder = OrderMaster::sum('total');
        $totalCustomers = Customer::count();
        $totalRevenue = OrderMaster::sum('total');
        $averagePurchase = $totalOrders ? $totalRevenue / $totalOrders : 0;

        $products = Product::all();
        $orders = OrderMaster::with('customer')->latest()->get();

        return view('admin.dashboard', compact('totalOrders', 'averageOrder', 'totalCustomers', 'averagePurchase', 'products', 'orders'));
    }
}
