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
            $query = Order::with(['user', 'details'])
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

            // Status filter
            if ($request->filled('status')) {
                if ($request->status === 'deleted') {
                    $query->whereNotNull('deleted_at');
                } else {
                    $query->whereNull('deleted_at')
                        ->where('order_status', $request->status);
                }
            }

            $sales = $query->paginate(10);

            // Calculate totals
            $totals = [
                'today' => [
                    'sales' => $query->clone()->whereDate('created_at', today())->sum('total'),
                    'orders' => $query->clone()->whereDate('created_at', today())->count(),
                ],
                'weekly' => [
                    'sales' => $query->clone()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total'),
                    'orders' => $query->clone()->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
                ],
                'monthly' => [
                    'sales' => $query->clone()->whereMonth('created_at', now()->month)->sum('total'),
                    'orders' => $query->clone()->whereMonth('created_at', now()->month)->count(),
                ],
                'total' => [
                    'sales' => $query->clone()->sum('total'),
                    'orders' => $query->clone()->count(),
                ],
                'deleted' => $query->clone()->whereNotNull('deleted_at')->count(),
            ];

            return view('sales.index', compact('sales', 'totals'));
        } catch (\Exception $e) {
            \Log::error('Sales index error: ' . $e->getMessage());
            return back()->with('error', 'Error loading sales data');
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