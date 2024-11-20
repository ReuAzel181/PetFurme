<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Temporarily disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Truncate the categories table (now it will not affect foreign key constraints)
        Category::truncate();

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Define the categories you want to seed
        $categories = collect([
            [
                'name'  => 'Food',
                'slug'  => 'Food',
                'user_id' => 1,
            ],
            [
                'name'  => 'Toy',
                'slug'  => 'Toy',
                'user_id' => 1,
            ],
            [
                'name'  => 'Grooming',
                'slug'  => 'Grooming',
                'user_id' => 1,
            ],
            [
                'name'  => 'Medicine',
                'slug'  => 'Medicine',
                'user_id' => 1,
            ],
            [
                'name'  => 'Accessory',
                'slug'  => 'Accessory',
                'user_id' => 1,
            ]
        ]);

        // Insert the categories into the database
        $categories->each(function ($category) {
            Category::insert($category);
        });
    }
}
