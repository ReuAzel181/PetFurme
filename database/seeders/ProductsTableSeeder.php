<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'uuid' => Str::uuid(),
                'user_id' => 1,
                'name' => 'Dog Food Premium',
                'slug' => 'dog-food-premium',
                'code' => 'DF001',
                'quantity' => 100,
                'buying_price' => 500,
                'selling_price' => 750,
                'quantity_alert' => 10,
                'category_id' => 1,
                'unit_id' => 1,
            ],
            // Add more products as needed
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
} 