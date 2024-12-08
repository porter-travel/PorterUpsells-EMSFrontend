<?php

namespace Database\Factories;
use App\Models\ProductSpecific;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductSpecific>
 */
class ProductSpecificFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => null,
            'value' => null,
            'product_id' => null, // Set to null by default
        ];
    }
}
