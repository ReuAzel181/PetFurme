<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        // Fetch all products from the database
        $products = Product::all(); // Or use pagination: Product::paginate(10);

        // Pass the products to the view
        return view('products.index', compact('products'));
    }

    // Show the form to create a new product
    public function create()
    {
        return view('products.create');
    }

    // Store the newly created product
    public function store(Request $request)
    {
        // Validate and store the product
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            // other validation rules
        ]);

        $product = Product::create($request->all());

        return redirect()->route('products.index')->with('success', 'Product created successfully!');
    }

    // Show the details of a specific product
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Show the form to edit a product
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Update the product
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric|min:0',
            'quantity_alert' => 'required|numeric|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }

}
