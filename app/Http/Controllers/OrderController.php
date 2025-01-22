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

class OrderController extends Controller
{
    public function create()
    {
        // Get users who are pet owners using the User model with proper model instances
        $petOwners = User::query()
            ->where('role', 'pet_owner')
            ->get(['id', 'name', 'email', 'role']);

        // Generate unique reference
        $reference = 'ORD-' . strtoupper(uniqid());

        $carts = Cart::content();

        return view('orders.create', compact('petOwners', 'reference', 'carts'));
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $order = Order::create([
                'uuid' => Str::uuid(),
                'user_id' => $request->id,
                'order_date' => now(), // This ensures accurate timestamp
                'total_products' => Cart::count(),
                'sub_total' => Cart::subtotal(),
                'vat' => Cart::tax(),
                'total' => Cart::total(),
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

    public function destroy(Order $order)
    {
        try {
            DB::beginTransaction();
            
            // Delete order details first
            $order->details()->delete();
            
            // Then delete the order
            $order->delete();
            
            DB::commit();
            
            return redirect()
                ->route('orders.index')
                ->with('success', "Order #{$order->invoice_no} deleted successfully");
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->route('orders.index')
                ->with('error', 'Error deleting order: ' . $e->getMessage());
        }
    }

    public function index()
    {
        $orders = Order::with(['user:id,name', 'details.product'])
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
} 