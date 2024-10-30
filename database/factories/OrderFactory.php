<?php

namespace database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'hotel_id' => 1,
            'user_id' => 1,
            'name' => fake()->name(),
            'total' => 1000,
            'status' => 'pending',
            'arrival_date' => date('Y-m-d'),
            'departure_date' => date('Y-m-d'),
            'subtotal' => 1000,
            'tax' => 0,
            'room_number' => rand(1, 100),
            'booking_reference' => 'ABC' . rand(100, 999),
        ];
    }
}
