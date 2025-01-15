<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderItem>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_id' => 1,
            'product_id' => 1,
            'variation_id' => 1,
            'product_name' => fake()->name(),
            'variation_name' => fake()->name(),
            'quantity' => 1,
            'price' => 1000,
            'image' => fake()->imageUrl(),
            'date' => date('Y-m-d'),
            'product_type' => 'product',

        ];
    }
}
