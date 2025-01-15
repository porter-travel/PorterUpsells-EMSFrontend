<?php

namespace Tests\Feature;

use App\Http\Controllers\CheckoutController;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class CalendarBookingsTest extends TestCase
{
    use RefreshDatabase;


    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_create_calendar_booking_from_checkout()
    {
        // Create a User
        $user = User::factory()->create();

        // Create a Hotel associated with the User
        $hotel = Hotel::factory()->create([
            'user_id' => $user->id,
        ]);

        //Create a Product

        $product = Product::factory()->create(['hotel_id' => $hotel->id, 'name' => 'Original Product', 'price' => 100, 'type' => 'calendar']);
        $product->specifics()->create(['name' => 'concurrent_availability', 'value' => '4']);
        $image = UploadedFile::fake()->image('product.jpg');
        $variant = $product->variations()->create(['image' => $image, 'name' => 'Original Variant', 'price' => 50]);

        $order = Order::factory()->create(['hotel_id' => $hotel->id]);
        $orderItems = OrderItem::factory()->create(['order_id' => $order->id, 'product_id' => $product->id, 'variation_id' => $variant->id, 'product_type' => 'calendar']);
        $orderItems->meta()->create(['key' => 'arrival_time', 'value' => '09:00']);
        $orderItems->meta()->create(['key' => 'end_time', 'value' => '11:00']);
//        dd($orderItems);
        $session = new \StdClass();
        $session->customer_details = new \StdClass();
        $session->customer_details->name = 'John Doe';
        $session->customer_details->email = 'fake@fake.com';
        $session->customer_details->phone = '1234567890';
        $session->payment_status = 'paid';

        $checkoutController = new CheckoutController();
        $checkoutController->createCalendarBooking($order, $session);

        $this->assertDatabaseHas('calendar_bookings', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'John Doe',
            'email' => 'fake@fake.com',
            'mobile' => '1234567890',
            'room_number' => null,
            'date' => date('Y-m-d'),
        ]);

    }

    public function test_gets_available_slots_in_checkout()
    {
        // Create a User
        $user = User::factory()->create();

        // Create a Hotel associated with the User
        $hotel = Hotel::factory()->create([
            'user_id' => $user->id,
        ]);

        //Create a Product

        $product = Product::factory()->create(['hotel_id' => $hotel->id, 'name' => 'Original Product', 'price' => 100, 'type' => 'calendar']);
        $product->specifics()->create(['name' => 'concurrent_availability', 'value' => '4']);
        $product->specifics()->create(['name' => 'time_intervals', 'value' => '2hrs']);
        $image = UploadedFile::fake()->image('product.jpg');
        $variant = $product->variations()->create(['image' => $image, 'name' => 'Original Variant', 'price' => 50]);


        $order = Order::factory()->create(['hotel_id' => $hotel->id]);
        $orderItems = OrderItem::factory()->create(['order_id' => $order->id, 'product_id' => $product->id, 'variation_id' => $variant->id, 'product_type' => 'calendar']);
        $orderItems->meta()->create(['key' => 'arrival_time', 'value' => '09:00']);
        $orderItems->meta()->create(['key' => 'end_time', 'value' => '11:00']);
//        dd($orderItems);
        $session = new \StdClass();
        $session->customer_details = new \StdClass();
        $session->customer_details->name = 'John Doe';
        $session->customer_details->email = 'fake@fake.com';
        $session->customer_details->phone = '1234567890';
        $session->payment_status = 'paid';

        $checkoutController = new CheckoutController();
        $checkoutController->createCalendarBooking($order, $session);


        $this->assertDatabaseHas('calendar_bookings', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'John Doe',
            'email' => 'fake@fake.com',
            'mobile' => '1234567890',
            'room_number' => null,
            'date' => date('Y-m-d'),
            'start_time' => '09:00',
            'end_time' => '11:00',
            'slot' => 1,
        ]);


        $order = Order::factory()->create(['hotel_id' => $hotel->id]);
        $orderItems = OrderItem::factory()->create(['order_id' => $order->id, 'product_id' => $product->id, 'variation_id' => $variant->id, 'product_type' => 'calendar']);
        $orderItems->meta()->create(['key' => 'arrival_time', 'value' => '09:00']);
        $orderItems->meta()->create(['key' => 'end_time', 'value' => '11:00']);
//        dd($orderItems);
        $session = new \StdClass();
        $session->customer_details = new \StdClass();
        $session->customer_details->name = 'Jane Doe';
        $session->customer_details->email = 'fake@2fake.com';
        $session->customer_details->phone = '123456789011';
        $session->payment_status = 'paid';

        $checkoutController = new CheckoutController();
        $checkoutController->createCalendarBooking($order, $session);

        $checkoutController->getAvailableSlotsForCalendarProduct($hotel->id, $product->id, date('Y-m-d'), '09:00', '11:00');


        $this->assertDatabaseHas('calendar_bookings', [
            'order_id' => $order->id,
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'Jane Doe',
            'slot' => 2,]);

    }
}
