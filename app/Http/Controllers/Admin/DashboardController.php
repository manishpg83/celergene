<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Customer;
use App\Models\OrderMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        $products = Product::latest()->take(5)->get();
        $orders = OrderMaster::with('customer')->latest()->take(5)->get();
        $recentCustomers = Customer::latest()->take(5)->get();

        $orderStats = OrderMaster::selectRaw('YEAR(invoice_date) as year, COUNT(*) as order_count')
            ->groupBy(DB::raw('YEAR(invoice_date)'))
            ->orderBy('year')
            ->get();

        $years = [];
        $orderCounts = [];

        foreach ($orderStats as $stat) {
            $years[] = $stat->year;
            $orderCounts[] = $stat->order_count;
        }

        return view('admin.dashboard', compact(
            'totalOrders',
            'averageOrder',
            'totalCustomers',
            'averagePurchase',
            'products',
            'orders',
            'recentCustomers',
            'years',
            'orderCounts'
        ));
    }
}
