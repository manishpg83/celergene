<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\OrderInvoice;
use App\Models\OrderMaster;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class DashboardController extends Controller
{
    public function index()
    {
        $currentMonth = now()->month;
        $currentYear = now()->year;

        $baseOrderQuery = OrderInvoice::where('invoice_category', '!=', 'shipping')
            ->whereYear('created_at', $currentYear)
            ->whereHas('order', function ($query) {
                $query->where('order_status', '!=', 'Cancelled');
            });

        $baseOrderQuery2 = OrderInvoice::where('invoice_category', '!=', 'shipping')
            ->whereYear('created_at', $currentYear)
            ->whereMonth('created_at', $currentMonth)
            ->whereHas('order', function ($query) {
                $query->where('order_status', '!=', 'Cancelled');
            });
        $averagePurchase = $baseOrderQuery2->sum('total');

        /*  $startDate = Carbon::create($this->year, 1, 1)->startOfDay();
        $endDate = Carbon::create($this->year, 12, 31)->endOfDay();

        $baseOrderQuery = OrderInvoice::where('invoice_category', '!=', 'shipping')
            ->whereYear('created_at', $currentYear)
             ->join('order_master', 'order_invoice.order_id', '=', 'order_master.order_id')
            ->whereBetween('order_invoice.created_at', [$startDate, $endDate])
            ->where('order_invoice.status', '!=', 'cancelled')
            ->where('order_master.order_status', '!=', 'Cancelled'); */


        $totalOrders = $baseOrderQuery->count();

        $totalRevenue = $baseOrderQuery->sum('total');

        //$averagePurchase = $totalOrders ? $totalRevenue / $totalOrders : 0;
        $totalCustomers = Customer::whereYear('created_at', $currentYear)->count();

        $products = Product::latest()->take(5)->get();
        $baseOrderQuery = OrderMaster::whereYear('order_date', $currentYear)
            ->where('order_status', '!=', 'Cancelled');
        $orders = (clone $baseOrderQuery)
            ->with('customer')
            ->where('order_type', 'offline')
            ->latest()
            ->take(5)
            ->get();

        $onlineorders = (clone $baseOrderQuery)
            ->with('customer')
            ->where('order_type', 'online')
            ->latest()
            ->take(5)
            ->get();

        $recentCustomers = Customer::latest()->take(5)->get();

        $orderStats = (clone $baseOrderQuery)
            ->selectRaw('MONTH(order_date) as month, COUNT(*) as order_count')
            ->groupBy(DB::raw('MONTH(order_date)'))
            ->orderBy('month')
            ->get();

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $monthlyOrderCounts = array_fill(0, 12, 0);
        foreach ($orderStats as $stat) {
            $monthlyOrderCounts[$stat->month - 1] = $stat->order_count;
        }

        return view('admin.dashboard', compact(
            'totalOrders',
            'totalRevenue',
            'totalCustomers',
            'averagePurchase',
            'products',
            'orders',
            'onlineorders',
            'recentCustomers',
            'months',
            'monthlyOrderCounts'
        ));
    }

}
