<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
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
            'email_address' => fake()->email(),
            'arrival_date' => date('Y-m-d'),
            'departure_date' => date('Y-m-d'),
            'booking_ref' => 'ABC123',
            'room' => rand(1, 100),
            'checkin' => fake()->boolean(50) ? date('Y-m-d') : null,
        ];
    }
}
