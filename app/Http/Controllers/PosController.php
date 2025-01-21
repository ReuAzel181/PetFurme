<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

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
        $validatedData = $request->validate([
            'id' => 'required|numeric',
            'name' => 'required|string',
            'selling_price' => 'required|numeric',
        ]);

        Cart::add([
            'id' => $validatedData['id'],
            'name' => $validatedData['name'],
            'qty' => 1,
            'price' => $validatedData['selling_price'],
            'weight' => 1,
            'options' => []
        ]);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function updateCartItem(Request $request, $rowId)
    {
        $validatedData = $request->validate([
            'qty' => 'required|numeric|min:1'
        ]);

        try {
            Cart::update($rowId, $validatedData['qty']);

            return response()->json([
                'success' => true,
                'subtotal' => number_format(Cart::subtotal(), 2),
                'total' => number_format(Cart::total(), 2)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart'
            ], 500);
        }
    }

    public function deleteCartItem(String $rowId)
    {
        Cart::remove($rowId);

        return redirect()
            ->back()
            ->with('success', 'Product has been deleted from cart!');
    }

    public function getCartTotals()
    {
        return response()->json([
            'subtotal' => number_format(Cart::subtotal(), 2),
            'total' => number_format(Cart::total(), 2)
        ]);
    }
}
