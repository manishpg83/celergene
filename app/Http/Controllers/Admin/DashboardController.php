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
        $currentYear = now()->year;
        $totalOrders = OrderMaster::whereYear('order_date',$currentYear)->count();
        $averageOrder = OrderMaster::whereYear('order_date',$currentYear)->sum('total');
        $totalCustomers = Customer::whereYear('created_at', $currentYear)->count();
        $totalRevenue = OrderMaster::whereYear('order_date',$currentYear)->sum('total');
        $averagePurchase = $totalOrders ? $totalRevenue / $totalOrders : 0;

        $products = Product::latest()->take(5)->get();
        $orders = OrderMaster::with('customer')
                ->whereYear('order_date', $currentYear)
                ->latest()->take(5)->get();
        $recentCustomers = Customer::latest()->take(5)->get();

        $orderStats = OrderMaster::selectRaw('YEAR(order_date) as year, COUNT(*) as order_count')
            ->groupBy(DB::raw('YEAR(order_date)'))
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
