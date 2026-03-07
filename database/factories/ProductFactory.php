<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'sku' => fake()->unique()->bothify('SKU-????-####'),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(10000, 1000000),
            'stock' => fake()->numberBetween(1, 100),
            'is_active' => true,
            'is_featured' => fake()->boolean(),
        ];
    }
}
