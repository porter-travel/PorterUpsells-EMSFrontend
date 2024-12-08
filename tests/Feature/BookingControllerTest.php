<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\CustomerEmail;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class BookingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_view_displays_correct_hotel()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('booking.create', $hotel->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.booking.create');
        $response->assertViewHas('hotel', $hotel);
    }

    public function test_store_creates_booking_and_sends_emails()
    {
        Mail::fake();
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $data = [
            'guest_name' => 'John Doe',
            'arrival_date' => now()->addDays(3)->format('Y-m-d'),
            'departure_date' => now()->addDays(5)->format('Y-m-d'),
            'email_address' => 'guest@example.com',
            'booking_ref' => 'ABC123',
            'send_email' => ['pre-arrival', 'welcome'], // 'welcome' sends immediately.
        ];

        $response = $this->actingAs($user)->post(route('booking.store', $hotel->id), $data);

        $response->assertRedirect(route('bookings.list', ['id' => $hotel->id]));

        // Check that the booking is created.
        $this->assertDatabaseHas('bookings', [
            'hotel_id' => $hotel->id,
            'name' => $data['guest_name'],
        ]);

        // Check that two CustomerEmail entries are created.
        $this->assertDatabaseCount('customer_emails', 2);

        // Assert that two emails were sent.
        Mail::assertSent(\App\Mail\CustomerEmail::class, 2);
    }


    public function test_list_shows_filtered_bookings()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $startDate = now()->format('Y-m-d');
        $endDate = now()->addDays(7)->format('Y-m-d');

        // Booking within range
        $booking1 = Booking::factory()->create([
            'hotel_id' => $hotel->id,
            'arrival_date' => now()->addDays(2)->format('Y-m-d'), // Within range.
            'departure_date' => now()->addDays(4)->format('Y-m-d'),
        ]);

        // Booking outside range
        $booking2 = Booking::factory()->create([
            'hotel_id' => $hotel->id,
            'arrival_date' => now()->addDays(10)->format('Y-m-d'), // Outside range.
            'departure_date' => now()->addDays(12)->format('Y-m-d'),
        ]);

        $response = $this->actingAs($user)->get(route('bookings.list', [
            'id' => $hotel->id,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]));

        $response->assertStatus(200);
        $response->assertViewIs('admin.booking.list');
        $response->assertViewHas('bookings', function ($bookings) use ($booking1, $booking2) {
            return $bookings->contains($booking1) && !$bookings->contains($booking2);
        });
    }


    public function test_list_redirects_if_user_is_not_authorized()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user2)->get(route('bookings.list', $hotel->id));

        $response->assertRedirect(route('dashboard'));
    }

    public function test_update_booking_updates_room_field()
    {
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);
        $booking = Booking::factory()->create(['hotel_id' => $hotel->id]);

        $response = $this->actingAs($user)->postJson(route('booking.update', $booking->id), [
            'room' => '101',
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Booking updated successfully']);
        $this->assertDatabaseHas('bookings', ['id' => $booking->id, 'room' => '101']);
    }
}
