<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Hotel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HotelTest extends TestCase
{
    use RefreshDatabase;

    public function test_hotel_can_be_created_with_a_user()
    {
        // Create a User
        $user = User::factory()->create();

        // Create a Hotel associated with the User
        $hotel = Hotel::factory()->create([
            'user_id' => $user->id,
        ]);

        // Assert the Hotel was created and is linked to the User
        $this->assertDatabaseHas('hotels', [
            'id' => $hotel->id,
            'user_id' => $user->id,
        ]);
    }

    public function test_hotel_creation_without_user_throws_error()
    {
        // Attempt to create a Hotel without a user
        $this->expectException(\Illuminate\Database\QueryException::class);

        Hotel::factory()->create();
    }
}

