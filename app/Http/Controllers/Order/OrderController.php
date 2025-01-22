<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\OrderStoreRequest;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\User;
use App\Mail\StockAlert;
use Carbon\Carbon;
use Gloudemans\Shoppingcart\Facades\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        // Get products
        $products = Product::where('user_id', auth()->id())
                          ->with(['category', 'unit'])
                          ->get();

        // Get users who are pet owners
        $customers = DB::table('users')
                      ->where('users.role', 'pet_owner')
                      ->leftJoin('customers', 'users.id', '=', 'customers.user_id')
                      ->select(
                          'users.id',
                          'users.name',
                          'users.email',
                          'users.phone'
                      )
                      ->get();

        // Generate unique reference
        $reference = 'ORD-' . strtoupper(uniqid());

        $carts = Cart::content();

        return view('orders.create', [
            'products' => $products,
            'petOwners' => $customers,
            'reference' => $reference,
            'carts' => $carts,
        ]);
    }

    public function store(Request $request)
    {
        \Log::info('Order store request:', $request->all());

        $validatedData = $request->validate([
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

            $order = Order::create([
                'uuid' => Str::uuid(),
                'user_id' => $request->id,
                'order_date' => $request->order_date,
                'reference' => $request->reference,
                'total_products' => $request->total_products,
                'sub_total' => $request->sub_total,
                'vat' => $request->vat,
                'total' => $request->total,
                'invoice_no' => $request->invoice_no,
            ]);

            // Create Order Details
            $contents = Cart::content();
            foreach ($contents as $content) {
                OrderDetails::create([
                    'order_id' => $order->id,
                    'product_id' => $content->id,
                    'quantity' => $content->qty,
                    'unitcost' => $content->price,
                    'total' => $content->subtotal,
                ]);
            }

            Cart::destroy();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'redirect' => route('orders.show', $order->uuid)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Order creation failed: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Order creation failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        $order->loadMissing(['details'])->get();
        return view('orders.show', [
            'order' => $order
        ]);
    }

    public function update($uuid, Request $request)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();

        // Reduce the stock
        $products = OrderDetails::where('order_id', $order->id)->get();

        $stockAlertProducts = [];

        foreach ($products as $product) {
            $productEntity = Product::where('id', $product->product_id)->first();
            $newQty = $productEntity->quantity - $product->quantity;
            if ($newQty < $productEntity->quantity_alert) {
                $stockAlertProducts[] = $productEntity;
            }
            $productEntity->update(['quantity' => $newQty]);
        }

        if (count($stockAlertProducts) > 0) {
            $listAdmin = [];
            foreach (User::all('email') as $admin) {
                $listAdmin [] = $admin->email;
            }
            Mail::to($listAdmin)->send(new StockAlert($stockAlertProducts));
        }

        return redirect()
            ->route('orders.index')
            ->with('success', 'Order has been updated!');
    }

    public function destroy($uuid)
    {
        $order = Order::where('uuid', $uuid)->firstOrFail();
        $order->delete();
    }

    public function downloadInvoice($uuid)
    {
        $order = Order::with('details')->where('uuid', $uuid)->firstOrFail();
        return view('orders.print-invoice', [
            'order' => $order,
        ]);
    }

    public function revertStatus($uuid)
    {
        try {
            $order = Order::where('uuid', $uuid)->firstOrFail();
            
            if ($order->is_paid) {
                return redirect()->back()->with('error', 'Cannot revert a paid order.');
            }

            $order->markAsIncomplete();

            return redirect()->back()->with('success', 'Order status reverted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error reverting order status: ' . $e->getMessage());
        }
    }

    public function markAsPaid(Request $request, Order $order)
    {
        try {
            DB::beginTransaction();

            $order->update([
                'is_paid' => true,
                'paid_at' => now(),
                'amount_received' => $request->amount_received,
                'change_amount' => $request->amount_received - $order->total,
                'payment_note' => $request->payment_note
            ]);

            DB::commit();
            
            return redirect()
                ->back()
                ->with('success', 'Payment recorded successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()
                ->back()
                ->with('error', 'Error recording payment: ' . $e->getMessage());
        }
    }
}
