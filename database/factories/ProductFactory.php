<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'uuid' =>fake()->uuid,
            'title' =>fake()->word,
            'price' =>fake()->randomFloat(2, 10, 100),
            'description' =>fake()->sentence,
            'metadata' => ['key' => 'value'], // Modify this to generate sample metadata
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
