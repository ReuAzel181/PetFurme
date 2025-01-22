<?php
namespace App\Http\Controllers;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index(Request $request)
    {
        try {
            // Get completed orders with filters
            $query = Order::with(['user', 'details'])
                ->where('order_status', 'completed')
                ->latest('created_at');

            // Date range filter
            if ($request->filled(['start_date', 'end_date'])) {
                $query->whereBetween('created_at', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            }

            // Customer filter
            if ($request->filled('customer')) {
                $query->whereHas('user', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->customer . '%');
                });
            }

            $sales = $query->paginate(10);

            // Calculate sales statistics
            $today = Carbon::today();
            $weekStart = Carbon::now()->startOfWeek();
            $monthStart = Carbon::now()->startOfMonth();

            // Today's sales
            $todaySales = $query->clone()
                ->whereDate('created_at', $today)
                ->sum('total');
            $todayOrders = $query->clone()
                ->whereDate('created_at', $today)
                ->count();

            // Weekly sales
            $weeklySales = $query->clone()
                ->where('created_at', '>=', $weekStart)
                ->sum('total');
            $weeklyOrders = $query->clone()
                ->where('created_at', '>=', $weekStart)
                ->count();

            // Monthly sales
            $monthlySales = $query->clone()
                ->where('created_at', '>=', $monthStart)
                ->sum('total');
            $monthlyOrders = $query->clone()
                ->where('created_at', '>=', $monthStart)
                ->count();

            // Total sales
            $totalSales = $query->clone()->sum('total');
            $totalOrders = $query->clone()->count();

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

    public function export(Request $request)
    {
        try {
            $query = Order::with(['user', 'details'])
                ->where('order_status', 'completed');

            if ($request->filled(['start_date', 'end_date'])) {
                $query->whereBetween('created_at', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            }

            $sales = $query->get();

            return response()->streamDownload(function() use ($sales) {
                $handle = fopen('php://output', 'w');
                
                // Headers
                fputcsv($handle, [
                    'Invoice No.',
                    'Customer',
                    'Date',
                    'Items',
                    'Total Amount',
                    'Payment Status'
                ]);

                foreach ($sales as $sale) {
                    fputcsv($handle, [
                        $sale->invoice_no,
                        $sale->user->name,
                        $sale->created_at->format('M d, Y H:i'),
                        $sale->details->count(),
                        number_format($sale->total, 2),
                        $sale->is_paid ? 'Paid' : 'Pending'
                    ]);
                }

                fclose($handle);
            }, 'sales-report-' . now()->format('Y-m-d') . '.csv');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error exporting sales data: ' . $e->getMessage());
        }
    }
}