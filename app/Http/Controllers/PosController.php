<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Cache;

class PosController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'unit'])->get();

        $customers = Customer::all()->sortBy('name');

        $carts = Cart::content();

        return view('pos.index', [
            'products' => $products,
            'customers' => $customers,
            'carts' => $carts,
        ]);
    }

    public function addCartItem(Request $request)
    {
        try {
            $product = Cache::remember('product_'.$request->id, 300, function () use ($request) {
                return Product::select('id', 'name', 'selling_price', 'product_image')
                    ->findOrFail($request->id);
            });
            
            Cart::add([
                'id' => $product->id,
                'name' => $product->name,
                'qty' => 1,
                'price' => $product->selling_price,
                'weight' => 0,
                'options' => [
                    'product_image' => $product->product_image
                ]
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully'
            ]);
        } catch (\Exception $e) {
            \Log::error('Cart Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart'
            ], 500);
        }
    }

    public function updateCartItem(Request $request, $rowId)
    {
        $rules = [
            'qty' => 'required|numeric',
            'product_id' => 'numeric'
        ];
        
        $validatedData = $request->validate($rules);
        if ($validatedData['qty'] > Product::where('id', intval($validatedData['product_id']))->value('quantity')) {
            return redirect()
            ->back()
            ->with('error', 'The requested quantity is not available in stock.');
        }
        

        Cart::update($rowId, $validatedData['qty']);

        return redirect()
            ->back()
            ->with('success', 'Product has been updated from cart!');
    }

    public function deleteCartItem(String $rowId)
    {
        Cart::remove($rowId);

        return redirect()
            ->back()
            ->with('success', 'Product has been deleted from cart!');
    }
}
