<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Cart;
use Illuminate\Support\Facades\Cache;

class OrderController
{
    public function create()
    {
        // Cache products for 10 minutes
        $products = Cache::remember('user_products_'.auth()->id(), 600, function () {
            return Product::where('user_id', auth()->id())
                ->with(['category', 'unit'])
                ->select('id', 'name', 'selling_price', 'quantity', 'product_image', 'user_id')
                ->get();
        });

        // Cache pet owners for 10 minutes
        $users = Cache::remember('pet_owners', 600, function () {
            return User::where('role', 'pet_owner')
                ->select('id', 'name', 'email')
                ->get();
        });

        $carts = Cart::content();

        return view('orders.create', compact('products', 'users', 'carts'));
    }
} 