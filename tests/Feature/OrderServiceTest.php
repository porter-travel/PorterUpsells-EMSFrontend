<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Models\Variation;
use App\Services\OrderService;
use Carbon\Carbon;
use database\factories\OrderFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class OrderServiceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_it_will_generate_order_array_for_email_and_admin_view(){
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create([
            'user_id' => $user->id,
        ]);
        $product = Product::factory()->create([
            'hotel_id' => $hotel->id,
        ]);
        $variation = Variation::factory()->create(
            ['price' => 100, 'product_id' => $product->id]
        );

        //Create an arrival date of today plus three days

        $arrivalDate = date('Y-m-d', strtotime('+3 days'));

        $booking = Booking::factory()->create([
            'hotel_id' => $hotel->id,
            'arrival_date' => $arrivalDate,
        ]);

        $order = Order::factory()->create([
            'hotel_id' => $hotel->id,
            'booking_id' => $booking->id,
            'payment_status' => 'paid',
            'arrival_date' => $booking->arrival_date,
        ]);

        $orderItems = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'variation_id' => $variation->id,
            'quantity' => 1,
        ]);

        //Create an arrival date of today plus 10 days

        $arrivalDate = date('Y-m-d', strtotime('+10 days'));

        $booking = Booking::factory()->create([
            'hotel_id' => $hotel->id,
            'arrival_date' => $arrivalDate,
        ]);

        $order = Order::factory()->create([
            'hotel_id' => $hotel->id,
            'booking_id' => $booking->id,
            'payment_status' => 'paid',
            'arrival_date' => $booking->arrival_date,
        ]);

        $orderItems = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'variation_id' => $variation->id,
            'quantity' => 1,
            'date' => $booking->arrival_date,
        ]);


        $service = new OrderService();

        //Create a start date of today and an end date of seven days from now

        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->addDays(7)->endOfDay();

        $orderArray = $service->generateOrderArrayForEmailAndAdminView($hotel->id, $startDate, $endDate);

        $this->assertCount(1, $orderArray);

    }

    public function test_it_will_get_orders_by_hotel_for_next_seven_days(){
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create([
            'user_id' => $user->id,
        ]);
        $product = Product::factory()->create([
            'hotel_id' => $hotel->id,
        ]);
        $variation = Variation::factory()->create(
            ['price' => 100, 'product_id' => $product->id]
        );

        //Create an arrival date of today plus three days

        $arrivalDate = date('Y-m-d', strtotime('+3 days'));

        $booking = Booking::factory()->create([
            'hotel_id' => $hotel->id,
            'arrival_date' => $arrivalDate,
        ]);

        $order = Order::factory()->create([
            'hotel_id' => $hotel->id,
            'booking_id' => $booking->id,
            'payment_status' => 'paid',
            'arrival_date' => $booking->arrival_date,
        ]);

        $orderItems = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'variation_id' => $variation->id,
            'quantity' => 1,
        ]);

        //Create an arrival date of today plus 10 days

        $arrivalDate = date('Y-m-d', strtotime('+10 days'));

        $booking = Booking::factory()->create([
            'hotel_id' => $hotel->id,
            'arrival_date' => $arrivalDate,
        ]);

        $order = Order::factory()->create([
            'hotel_id' => $hotel->id,
            'booking_id' => $booking->id,
            'payment_status' => 'paid',
            'arrival_date' => $booking->arrival_date,
        ]);

        $orderItems = OrderItem::factory()->create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'variation_id' => $variation->id,
            'quantity' => 1,
            'date' => $booking->arrival_date,
        ]);


        $service = new OrderService();

        $orderArray = $service->getOrdersByHotelForNextSevenDays($hotel->id);

    }
}
