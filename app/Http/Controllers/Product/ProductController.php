<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Picqer\Barcode\BarcodeGeneratorHTML;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        // Retrieve all products for the authenticated user
        $products = Product::where("user_id", auth()->id())
            ->with(['category', 'unit']) // Eager load relationships
            ->latest()  // Order by latest first
            ->get();

        \Log::info('Fetched products:', [
            'count' => $products->count(),
            'user_id' => auth()->id()
        ]);

        return view('products.index', compact('products'));
    }

    public function create(Request $request)
    {
        // Retrieve categories and units for the authenticated user
        $categories = Category::where("user_id", auth()->id())->get(['id', 'name']);
        $units = Unit::where("user_id", auth()->id())->get(['id', 'name']);

        // Filter categories and units based on query parameters if provided
        if ($request->has('category')) {
            $categories = Category::where("user_id", auth()->id())->whereSlug($request->get('category'))->get();
        }

        if ($request->has('unit')) {
            $units = Unit::where("user_id", auth()->id())->whereSlug($request->get('unit'))->get();
        }

        return view('products.create', [
            'categories' => $categories,
            'units' => $units,
        ]);
    }

    public function store(StoreProductRequest $request)
    {
        /**
         * Handle image upload
         */
        $image = "";
        $imageData = null;
        if ($request->hasFile('product_image')) {
            // Store file path for web display
            $file = $request->file('product_image');
            $image = $file->store('products', 'public');
            
            // Store binary data for mobile app
            $imageData = file_get_contents($file->getRealPath());
        }

        // Create a new product with the provided data
        Product::create([
            "code" => IdGenerator::generate([
                'table' => 'products',
                'field' => 'code',
                'length' => 4,
                'prefix' => 'PC'
            ]),
            'product_image'      => $image,
            'product_image_data' => $imageData,
            'name'              => $request->name,
            'category_id'       => $request->category_id,
            'unit_id'           => $request->unit_id,
            'quantity'          => $request->quantity,
            'buying_price'      => $request->buying_price,
            'selling_price'     => $request->selling_price,
            'quantity_alert'    => $request->quantity_alert,
            'tax'               => $request->tax,
            'tax_type'          => $request->tax_type,
            'notes'             => $request->notes,
            "user_id"           => auth()->id(),
            "slug"              => Str::slug($request->name, '-'),
            "uuid"              => Str::uuid()
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been created!');
    }

    public function show($uuid)
    {
        // Retrieve product by UUID and generate a barcode
        $product = Product::where("uuid", $uuid)->firstOrFail();
        $generator = new BarcodeGeneratorHTML();
        $barcode = $generator->getBarcode($product->code, $generator::TYPE_CODE_128);

        return view('products.show', [
            'product' => $product,
            'barcode' => $barcode,
        ]);
    }

    public function edit($uuid)
    {
        // Debug logging
        \Log::info('Attempting to edit product', ['uuid' => $uuid]);

        $product = Product::where('uuid', $uuid)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        \Log::info('Found product', ['product' => $product->toArray()]);

        $categories = Category::where("user_id", auth()->id())->get(['id', 'name']);
        $units = Unit::where("user_id", auth()->id())->get(['id', 'name']);

        return view('products.edit', compact('product', 'categories', 'units'));
    }

    public function update(UpdateProductRequest $request, $uuid)
    {
        $product = Product::where("uuid", $uuid)->firstOrFail();

        // Update product with all fields except image-related fields
        $product->update($request->except(['product_image', 'product_image_data']));

        $image = $product->product_image;
        $imageData = $product->product_image_data;
        
        if ($request->hasFile('product_image')) {
            // Delete old image if exists
            if ($product->product_image) {
                $oldImagePath = public_path('storage/') . $product->product_image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
            
            $file = $request->file('product_image');
            $image = $file->store('products', 'public');
            $imageData = file_get_contents($file->getRealPath());
        }

        // Update remaining product fields
        $product->name = $request->name;
        $product->slug = Str::slug($request->name, '-');
        $product->category_id = $request->category_id;
        $product->unit_id = $request->unit_id;
        $product->quantity = $request->quantity;
        $product->buying_price = $request->buying_price;
        $product->selling_price = $request->selling_price;
        $product->quantity_alert = $request->quantity_alert;
        $product->tax = $request->tax;
        $product->tax_type = $request->tax_type;
        $product->notes = $request->notes;
        $product->product_image = $image;
        $product->product_image_data = $imageData;
        $product->save();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product updated successfully!');
    }

    public function destroy($uuid)
    {
        // Retrieve product by UUID and delete its image if exists
        $product = Product::where("uuid", $uuid)->firstOrFail();

        if ($product->product_image) {
            $imagePath = public_path('storage/') . $product->product_image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', 'Product has been deleted!');
    }
}
