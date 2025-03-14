<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Support\Facades\Storage;

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
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        
        if ($request->hasFile('product_image')) {
            // Store the file path
            $path = $request->file('product_image')->store('products', 'public');
            $data['product_image'] = $path;
            
            // Store the binary data
            $data['product_image_data'] = file_get_contents($request->file('product_image')->getRealPath());
        }
        
        // Add user_id and generate uuid/slug
        $data['user_id'] = auth()->id();
        $data['uuid'] = \Str::uuid();
        $data['slug'] = \Str::slug($data['name']);
        
        // Create product
        Product::create($data);
        
        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
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

        if ($request->hasFile('product_image')) {
            // Delete old image if exists
            if ($product->product_image) {
                Storage::disk('public')->delete($product->product_image);
            }
            
            // Store the new image
            $path = $request->file('product_image')->store('products', 'public');
            $product->product_image = $path;
            
            // Optionally store binary data if needed
            $product->product_image_data = file_get_contents($request->file('product_image')->getRealPath());
        }

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
