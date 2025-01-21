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

        return view('orders.create', [
            'products' => Product::where('status', 'active')->get(),
            'petOwners' => $petOwners,
            'reference' => $reference,
            'carts' => $carts,
        ]);
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'order_date' => 'required|date',
            'reference' => 'required|string',
            'total_products' => 'required|numeric',
            'sub_total' => 'required|numeric',
            'vat' => 'required|numeric',
            'total' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();
            
            // Create the order
            $order = Order::create([
                'uuid' => Str::uuid(),
                'user_id' => $request->id, // This is the pet owner's ID
                'customer_id' => null, // Set to null since we're not using it
                'order_date' => $request->order_date,
                'reference' => $request->reference,
                'total_products' => $request->total_products,
                'sub_total' => $request->sub_total,
                'vat' => $request->vat,
                'total' => $request->total,
                'invoice_no' => $request->invoice_no,
            ]);

            // Create order details for each cart item
            foreach (Cart::content() as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                    'quantity' => $item->qty,
                    'unitcost' => $item->price,
                    'total' => $item->subtotal,
                ]);
            }

            // Clear the cart
            Cart::destroy();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order placed successfully!',
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
        $orders = Order::select([
            'id', 
            'uuid', 
            'user_id', 
            'order_date', 
            'total', 
            'invoice_no', 
            'is_paid'
        ])
        ->with('user:id,name')
        ->latest()
        ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function markAsPaid(Request $request, Order $order)
    {
        $request->validate([
            'amount_received' => 'required|numeric|min:' . $order->total,
            'note' => 'nullable|string|max:500'
        ]);

        $order->update([
            'is_paid' => true,
            'amount_received' => $request->amount_received,
            'change_amount' => $request->amount_received - $order->total,
            'paid_at' => now(),
            'payment_note' => $request->note
        ]);
        
        return redirect()
            ->back()
            ->with('success', 'Payment processed successfully');
    }
} 