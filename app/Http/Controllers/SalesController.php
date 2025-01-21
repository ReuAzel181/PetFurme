<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
    {
        try {
            // Get all orders first without the where clause
            $sales = Order::with('user')
                ->latest('created_at')
                ->paginate(10);

            // Calculate sales statistics
            $today = Carbon::today();
            $weekStart = Carbon::now()->startOfWeek();
            $monthStart = Carbon::now()->startOfMonth();

            // Today's sales
            $todaySales = Order::whereDate('created_at', $today)
                ->sum('total');
            $todayOrders = Order::whereDate('created_at', $today)
                ->count();

            // Weekly sales
            $weeklySales = Order::where('created_at', '>=', $weekStart)
                ->sum('total');
            $weeklyOrders = Order::where('created_at', '>=', $weekStart)
                ->count();

            // Monthly sales
            $monthlySales = Order::where('created_at', '>=', $monthStart)
                ->sum('total');
            $monthlyOrders = Order::where('created_at', '>=', $monthStart)
                ->count();

            // Total sales
            $totalSales = Order::sum('total');
            $totalOrders = Order::count();

            return view('sales.index', compact(
                'sales',
                'todaySales',
                'todayOrders',
                'weeklySales',
                'weeklyOrders',
                'monthlySales',
                'monthlyOrders',
                'totalSales',
                'totalOrders'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading sales data: ' . $e->getMessage());
        }
    }
}