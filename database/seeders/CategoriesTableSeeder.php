<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Food', 'slug' => 'food', 'user_id' => 1],
            ['name' => 'Toy', 'slug' => 'toy', 'user_id' => 1],
            ['name' => 'Grooming', 'slug' => 'grooming', 'user_id' => 1],
            ['name' => 'Medicine', 'slug' => 'medicine', 'user_id' => 1],
            ['name' => 'Accessory', 'slug' => 'accessory', 'user_id' => 1],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
} 