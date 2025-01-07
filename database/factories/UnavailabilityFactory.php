<?php

namespace Database\Factories;
use App\Models\Unavailability;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unavailability>
 */
class UnavailabilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = date('Y-m-d');
        $endDate = date('Y-m-d', strtotime($startDate . ' + 7 days'));
        return [
            'product_id' => null,
            'start_at' => date('Y-m-d'),
            'end_at' =>  $endDate,
            'is_recurrent' => false,
        ];
    }
}
