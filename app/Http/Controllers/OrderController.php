<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Str;
use App\Models\OrderDetail;
use App\Models\Sale;
use App\Models\ArchivedOrder;
use App\Models\ArchivedOrderDetail;

class OrderController extends Controller
{
    public function create()
    {
        // Get products with their relationships
        $products = Product::with(['category', 'unit'])->get();

        // Get users who are pet owners
        $petOwners = User::query()
            ->where('role', 'pet_owner')
            ->get(['id', 'name', 'email', 'role']);

        // Generate unique reference
        $reference = 'ORD-' . strtoupper(uniqid());

        $carts = Cart::content();

        return view('orders.create', compact('products', 'petOwners', 'reference', 'carts'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $order = Order::create([
                'uuid' => Str::uuid(),
                'user_id' => $request->id,
                'order_date' => now(),
                'total_products' => Cart::count(),
                'sub_total' => Cart::subtotal(2, '.', ''),
                'vat' => Cart::tax(2, '.', ''),
                'total' => Cart::total(2, '.', ''),
                'invoice_no' => 'INV-' . strtoupper(uniqid()),
                'reference' => $request->reference,
                'note' => $request->note
            ]);

            foreach (Cart::content() as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'quantity' => $item->qty,
                    'unitcost' => $item->price,
                    'total' => $item->subtotal
                ]);
            }

            Cart::destroy();
            DB::commit();

            // Load relationships after creation
            $order->load(['details.product']);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully!',
                'redirect' => route('orders.show', $order->uuid)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order. Please try again.'
            ], 500);
        }
    }

    public function destroy($uuid)
    {
        try {
            DB::beginTransaction();

            // Find the order by uuid
            $order = Order::where('uuid', $uuid)->firstOrFail();

            // Instead of deleting, update the status and add deleted_at timestamp
            $order->update([
                'deleted_at' => now(),
                'deletion_reason' => request('reason', 'Order deleted by user')
            ]);

            DB::commit();
            
            return redirect()->route('orders.index')
                ->with('success', "Order #{$order->invoice_no} has been marked as deleted.");

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Delete error:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('orders.index')
                ->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $orders = Order::with(['user:id,name', 'details.product'])
            ->whereNull('deleted_at')  // Only show non-deleted orders
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Load the relationships
        $order->load(['user:id,name', 'details.product']);
        return view('orders.show', compact('order'));
    }

    public function markAsPaid(Request $request, Order $order)
    {
        try {
            DB::beginTransaction();

            // Update order status
            $order->update([
                'order_status' => 'completed'  // Make sure 'order_status' is in your $fillable array
            ]);

            // Create sale record
            $sale = Sale::create([
                'uuid' => Str::uuid(),
                'order_id' => $order->id,
                'user_id' => $order->user_id,
                'invoice_no' => $order->invoice_no,
                'amount_received' => $request->amount_received,
                'change_amount' => $request->amount_received - $order->total,
                'total_amount' => $order->total,
                'payment_note' => $request->payment_note,
                'payment_date' => now()
            ]);

            DB::commit();
            return redirect()
                ->route('orders.index')
                ->with('success', 'Payment processed successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('orders.index')
                ->with('error', 'Failed to process payment: ' . $e->getMessage());
        }
    }

    public function printInvoice(Order $order)
    {
        $order->load(['user', 'details.product']); // Eager load relationships
        
        return view('orders.print-invoice', [
            'order' => $order
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:completed,cancelled'
        ]);

        try {
            DB::beginTransaction();

            $order->update([
                'order_status' => $request->status,
                'completed_at' => $request->status === 'completed' ? now() : null
            ]);

            // Load relationships after update
            $order->load(['details.product']);

            DB::commit();

            $message = $request->status === 'completed' 
                ? 'Order completed successfully'
                : 'Order cancelled successfully';

            return redirect()
                ->route('orders.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order status update failed: ' . $e->getMessage());
            
            return redirect()
                ->route('orders.index')
                ->with('error', 'Error updating order: ' . $e->getMessage());
        }
    }

    public function archived()
    {
        $query = ArchivedOrder::with('archivedDetails')
            ->when(request('filter'), function($query, $filter) {
                if (in_array($filter, ['completed', 'cancelled'])) {
                    $query->where('archive_reason', $filter);
                }
            })
            ->latest('archived_at');

        // Debug query
        \Log::info('Archive Query:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'total_records' => $query->count()
        ]);

        $archivedOrders = $query->paginate(10);

        return view('orders.archived', compact('archivedOrders'));
    }

    public function markAsCompleted(Order $order)
    {
        try {
            DB::beginTransaction();

            // Archive the order
            $archivedOrder = ArchivedOrder::create([
                'uuid' => $order->uuid,
                'original_id' => $order->id,
                'user_id' => $order->user_id,
                'customer_name' => $order->user->name,
                'order_date' => $order->order_date,
                'total_products' => $order->total_products,
                'sub_total' => $order->sub_total,
                'vat' => $order->vat,
                'total' => $order->total,
                'invoice_no' => $order->invoice_no,
                'note' => $order->note,
                'is_paid' => $order->is_paid,
                'amount_received' => $order->amount_received,
                'change_amount' => $order->change_amount,
                'paid_at' => $order->paid_at,
                'payment_note' => $order->payment_note,
                'archive_reason' => 'completed',
                'archived_at' => now(),
            ]);

            // Archive order details
            foreach ($order->details as $detail) {
                ArchivedOrderDetail::create([
                    'archived_order_id' => $archivedOrder->id,
                    'product_name' => $detail->product->name,
                    'quantity' => $detail->quantity,
                    'unit_price' => $detail->unitcost,
                    'total' => $detail->total
                ]);
            }

            // Delete the original order
            $order->details()->delete();
            $order->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Order marked as completed and archived.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to complete order: ' . $e->getMessage());
        }
    }

    public function cancel(Request $request, Order $order)
    {
        try {
            DB::beginTransaction();

            // Archive the order
            $archivedOrder = ArchivedOrder::create([
                'uuid' => $order->uuid,
                'original_id' => $order->id,
                'user_id' => $order->user_id,
                'customer_name' => $order->user->name,
                'order_date' => $order->order_date,
                'total_products' => $order->total_products,
                'sub_total' => $order->sub_total,
                'vat' => $order->vat,
                'total' => $order->total,
                'invoice_no' => $order->invoice_no,
                'note' => $order->note,
                'is_paid' => $order->is_paid,
                'amount_received' => $order->amount_received,
                'change_amount' => $order->change_amount,
                'paid_at' => $order->paid_at,
                'payment_note' => $order->payment_note,
                'archive_reason' => 'cancelled',
                'archive_note' => $request->cancellation_reason,
                'archived_at' => now(),
            ]);

            // Archive order details
            foreach ($order->details as $detail) {
                ArchivedOrderDetail::create([
                    'archived_order_id' => $archivedOrder->id,
                    'product_name' => $detail->product->name,
                    'quantity' => $detail->quantity,
                    'unit_price' => $detail->unitcost,
                    'total' => $detail->total
                ]);
            }

            // Delete the original order
            $order->details()->delete();
            $order->delete();

            DB::commit();
            return redirect()->back()->with('success', 'Order cancelled and archived.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to cancel order: ' . $e->getMessage());
        }
    }

    public function deleted()
    {
        $orders = Order::with(['user:id,name', 'details.product'])
            ->whereNotNull('deleted_at')
            ->latest('deleted_at')
            ->paginate(10);

        return view('orders.deleted', compact('orders'));
    }
} 