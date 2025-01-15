<?php

namespace Database\Factories;
use App\Models\Order;
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
            'name' => fake()->name(),
            'total' => 1000,
            'payment_status' => 'pending',
            'status' => 'pending',
            'arrival_date' => date('Y-m-d'),
            'departure_date' => date('Y-m-d'),
            'subtotal' => 1000,
            'total_tax' => 0,
            'room_number' => rand(1, 100),
            'booking_ref' => 'ABC' . rand(100, 999),
            'booking_id' => 1,
        ];
    }
}
