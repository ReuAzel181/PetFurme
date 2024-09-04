<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */


    public function run(): void
    {

        Category::truncate();
        
        $categories = collect([
            [
                // 'id'    => 1,
                'name'  => 'Food',
                'slug'  => 'Food',
                'user_id' => 1,
            ],
            [
                // 'id'    => 2,
                'name'  => 'Toy',
                'slug'  => 'Toy',
                'user_id' => 1,
            ],
            [
                // 'id'    => 3,
                'name'  => 'Grooming',
                'slug'  => 'Grooming',
                'user_id' => 1,
            ],
            [
                // 'id'    => 4,
                'name'  => 'Medicine',
                'slug'  => 'Medicine',
                'user_id' => 1,
            ],
            [
                // 'id'    => 5,
                'name'  => 'Accessory',
                'slug'  => 'Accessory',
                'user_id' => 1,
            ]
        ]);

        $categories->each(function ($category) {
            Category::insert($category);
        });
    }
}
