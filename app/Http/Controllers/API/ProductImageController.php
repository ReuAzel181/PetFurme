<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductImageController extends Controller
{
    public function getBinaryImage(Product $product)
    {
        if (!$product->product_image_data) {
            return response()->json(['error' => 'No image found'], 404);
        }

        return response($product->product_image_data)
            ->header('Content-Type', 'image/jpeg');
    }
} 