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
        $totalOrders = OrderMaster::whereYear('order_date', $currentYear)->count();
        $averageOrder = OrderMaster::whereYear('order_date', $currentYear)->sum('total');
        $totalCustomers = Customer::whereYear('created_at', $currentYear)->count();
        $totalRevenue = OrderMaster::whereYear('order_date', $currentYear)->sum('total');
        $averagePurchase = $totalOrders ? $totalRevenue / $totalOrders : 0;

        $products = Product::latest()->take(5)->get();
        $orders = OrderMaster::with('customer')
            ->whereYear('order_date', $currentYear)
            ->latest()->take(5)->get();
        $recentCustomers = Customer::latest()->take(5)->get();

        $orderStats = OrderMaster::selectRaw('MONTH(order_date) as month, COUNT(*) as order_count')
            ->whereYear('order_date', $currentYear)
            ->groupBy(DB::raw('MONTH(order_date)'))
            ->orderBy('month')
            ->get();

        $months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        $monthlyOrderCounts = array_fill(0, 12, 0);

        foreach ($orderStats as $stat) {
            $monthlyOrderCounts[$stat->month - 1] = $stat->order_count;
        }

        return view('admin.dashboard', compact(
            'totalOrders',
            'averageOrder',
            'totalCustomers',
            'averagePurchase',
            'products',
            'orders',
            'recentCustomers',
            'months',
            'monthlyOrderCounts'
        ));
    }
}
