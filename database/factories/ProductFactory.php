<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'user_id' => 1,
            'name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'code' => 'PRD-' . $this->faker->unique()->numberBetween(1000, 9999),
            'quantity' => $this->faker->numberBetween(10, 100),
            'buying_price' => $this->faker->numberBetween(100, 1000),
            'selling_price' => $this->faker->numberBetween(1000, 2000),
            'quantity_alert' => 10,
            'category_id' => 1,
            'unit_id' => 1,
        ];
    }
}
