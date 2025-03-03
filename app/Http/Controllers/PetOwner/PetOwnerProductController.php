<?php

namespace App\Http\Controllers\PetOwner;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PetOwnerProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::with(['category', 'unit'])->get(); // Eager loading relationships
        return view('pet-owner.products.index', compact('products'));
    }
} 