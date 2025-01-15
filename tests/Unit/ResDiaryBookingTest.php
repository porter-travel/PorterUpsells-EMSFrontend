<?php
namespace Tests\Unit;

use App\Models\Hotel;
use App\Models\OrderResdiary;
use App\Models\User;
use App\Services\ResDiary\ResDiaryBooking;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Mockery;
use Tests\TestCase;

class ResDiaryBookingTest extends TestCase
{

    use RefreshDatabase;

    public function test_createBooking_formatsCartDataCorrectlyAndMakesApiCall()
    {

        $user = User::factory()->create();
        $hotel = Hotel::factory()->create([
            'user_id' => $user->id,
        ]);
        // Arrange: Prepare data to be used in the test
        $accessToken = 'test_access_token';
        $resdiary_microsite_name = 'test_microsite';
        $cartData = [
            'date' => '2024-12-15',
            'quantity' => 4,
            'cart_item_meta' => [
                'arrival_time' => '18:30',
                'resdiary_promotion_id' => 'promo_123'
            ],
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'phone' => '1234567890'
        ];
        $hotel_id = $hotel->id;

        // Mock the HTTP response for the API call
        Http::fake([
            'https://api.rdbranch.com/api/ConsumerApi/v1/Restaurant/*/BookingWithStripeToken' => Http::response([
                'Status' => 'Success',
                'Booking' => [
                    'Id' => '1234',
                    'Reference' => 'ABC123'
                ]
            ], 200),
        ]);

        // Act: Call the createBooking method
        $response = ResDiaryBooking::createBooking($accessToken, $resdiary_microsite_name, $cartData, $hotel_id);

        // Assert: Check that the data is correctly formatted and saved
        $this->assertEquals([
            "Status" => "Success",
            "Booking" => [
                "Id" => "1234",
                "Reference" => "ABC123"
            ]
        ], $response);  // Ensure that the data returned matches the mock API response

        // Ensure that the OrderResdiary model is used
        $this->assertDatabaseHas('orders_resdiary', [
            'hotel_id' => $hotel_id,
            'resdiary_id' => '1234',
            'resdiary_reference' => 'ABC123',
            'visit_date' => '2024-12-15',
            'visit_time' => '18:30',
            'party_size' => 4,
        ]);
    }
}
