<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class CartController extends Controller
{
    public function add(Request $request, $productId)
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string',
                'price' => 'required|numeric',
            ]);

            Cart::add([
                'id' => $productId,
                'name' => $validatedData['name'],
                'qty' => 1,
                'price' => $validatedData['price'],
                'weight' => 0,
                'options' => []
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'cartCount' => Cart::count(),
                'cartTotal' => Cart::total()
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $rowId)
    {
        $request->validate([
            'qty' => 'required|numeric|min:1'
        ]);

        try {
            Cart::update($rowId, $request->qty);

            return response()->json([
                'success' => true,
                'price' => Cart::get($rowId)->price,
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

    public function delete()
    {

    }

    public function destroy($rowId)
    {
        try {
            Cart::remove($rowId);
            
            return response()->json([
                'success' => true,
                'message' => 'Item removed successfully',
                'subtotal' => number_format(Cart::subtotal(), 2),
                'total' => number_format(Cart::total(), 2)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item'
            ], 500);
        }
    }

    public function getCartTotals()
    {
        return response()->json([
            'subtotal' => number_format(Cart::subtotal(), 2),
            'total' => number_format(Cart::total(), 2)
        ]);
    }
}
