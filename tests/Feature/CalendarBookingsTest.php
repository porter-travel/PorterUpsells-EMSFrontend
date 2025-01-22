<?php

namespace Tests\Feature;

use App\Http\Controllers\CalendarBookingController;
use App\Http\Controllers\CheckoutController;
use App\Models\CalendarBooking;
use App\Models\Hotel;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\OrderItem;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use Illuminate\Http\Request;

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

    public function test_getting_availability_for_product_on_same_day()
    {

        $this->refreshDatabase();
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
        $product->specifics()->create(['name' => 'available_saturday', 'value' => '1']);
        $product->specifics()->create(['name' => 'start_time_saturday', 'value' => '09:00']);
        $product->specifics()->create(['name' => 'end_time_saturday', 'value' => '17:00']);
        $image = UploadedFile::fake()->image('product.jpg');
        $variant = $product->variations()->create(['image' => $image, 'name' => 'Original Variant', 'price' => 50]);

        CalendarBooking::create([
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'John Doe',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'hotel_id' => $hotel->id,
            'date' => '2025-01-25',
            'status' => 'confirmed',
            'qty' => 1,
            'slot' => 1,
        ]);

        $this->assertDatabaseHas('calendar_bookings', [
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'John Doe',
            'start_time' => '09:00:00',
            'end_time' => '11:00:00',
            'hotel_id' => $hotel->id,
            'date' => '2025-01-25',
            'status' => 'confirmed',
            'qty' => 1,
            'slot' => 1,
        ]);


        $controller = new CalendarBookingController();

        $data = [
            'slot' => 1,
            'date' => '2025-01-25',
            'start_time' => '11:00:00',
//            'end_time' => '13:00:00',
        ];

        $request = Request::create('/test-endpoint', 'POST', $data);


        $response = $controller->getFutureAvailabilityOnSameDayForProduct($product->id, $request);


        $this->assertEquals(["13:00:00", "15:00:00", "17:00:00"], $response);

        CalendarBooking::create([
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'John Doe',
            'start_time' => '15:00:00',
            'end_time' => '17:00:00',
            'hotel_id' => $hotel->id,
            'date' => '2025-01-25',
            'status' => 'confirmed',
            'qty' => 1,
            'slot' => 1,
        ]);


        $data = [
            'slot' => 1,
            'date' => '2025-01-25',
            'start_time' => '13:00',
            'end_time' => '15:00',
        ];

        $request = Request::create('/test-endpoint', 'POST', $data);
        $response = $controller->getFutureAvailabilityOnSameDayForProduct($product->id, $request);
        $this->assertEquals(["13:00:00", "15:00:00"], $response);

    }

    public function test_it_will_store_a_booking()
    {
        $this->refreshDatabase();
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
        $product->specifics()->create(['name' => 'available_saturday', 'value' => '1']);
        $product->specifics()->create(['name' => 'start_time_saturday', 'value' => '09:00']);
        $product->specifics()->create(['name' => 'end_time_saturday', 'value' => '17:00']);
        $image = UploadedFile::fake()->image('product.jpg');
        $variant = $product->variations()->create(['image' => $image, 'name' => 'Original Variant', 'price' => 50]);

        $response = $this->actingAs($user)->post(route('calendar.store-booking', ['hotel_id' => $hotel->id, 'product_id' => $product->id]), [
                'name' => 'John Doe',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'room' => '123',
                'date' => '2025-01-25',
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'slot' => 1,
                'qty' => 1,
                'status' => 'confirmed',
            ]
        );

        $response->assertStatus(302);

        $this->assertDatabaseHas('calendar_bookings', [
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'mobile' => '1234567890',
            'room_number' => '123',
            'start_time' => '09:00',
            'end_time' => '11:00',
            'slot' => 1,
            'qty' => 1,
            'status' => 'confirmed',
        ]);

        $response = $this->actingAs($user)->post(route('calendar.store-booking', ['hotel_id' => $hotel->id, 'product_id' => $product->id]), [
                'name' => 'John Doe',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'room' => '123',
                'date' => '2025-01-25',
                'start_time' => '11:00:00',
                'end_time' => '17:00:00',
                'slot' => 1,
                'qty' => 1,
                'status' => 'confirmed',
            ]
        );

        $this->assertDatabaseHas('calendar_bookings', [
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'mobile' => '1234567890',
            'room_number' => '123',
            'start_time' => '11:00',
            'end_time' => '13:00',
            'slot' => 1,
            'qty' => 1,
            'status' => 'confirmed',
        ]);

        $this->assertDatabaseHas('calendar_bookings', [
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'mobile' => '1234567890',
            'room_number' => '123',
            'start_time' => '13:00',
            'end_time' => '15:00',
            'slot' => 1,
            'qty' => 1,
            'status' => 'confirmed',
        ]);
    }

    public function test_it_will_update_a_calendar_booking(){
        $this->refreshDatabase();
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
        $product->specifics()->create(['name' => 'available_saturday', 'value' => '1']);
        $product->specifics()->create(['name' => 'start_time_saturday', 'value' => '09:00']);
        $product->specifics()->create(['name' => 'end_time_saturday', 'value' => '17:00']);
        $image = UploadedFile::fake()->image('product.jpg');
        $variant = $product->variations()->create(['image' => $image, 'name' => 'Original Variant', 'price' => 50]);

        $response = $this->actingAs($user)->post(route('calendar.store-booking', ['hotel_id' => $hotel->id, 'product_id' => $product->id]), [
                'name' => 'John Doe',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'room' => '123',
                'date' => '2025-01-25',
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'slot' => 1,
                'qty' => 1,
                'status' => 'confirmed',
            ]
        );

        $response->assertStatus(302);

        $booking = CalendarBooking::first();




        $response = $this->actingAs($user)->post(route('calendar.update-booking'), [
                'booking_id' => $booking->id,
                'name' => 'Jane Doe',
                'email' => 'test2@demo.com',
                'phone' => '123456789000',
                'room' => '1234',
                'date' => '2025-01-25',
                'start_time' => '11:00:00',
                'end_time' => '15:00:00',
                'slot' => 1,
                'qty' => 1,
                'status' => 'confirmed',
            ]);

        $this->assertDatabaseHas('calendar_bookings', [
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'Jane Doe',
            'email' => 'test2@demo.com',
            'mobile' => '123456789000',
            'room_number' => '1234',
            'start_time' => '11:00',
            'end_time' => '13:00',
            'slot' => 1,
            'qty' => 1,
            'status' => 'confirmed',
        ]);

        $this->assertDatabaseHas('calendar_bookings', [
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'Jane Doe',
            'email' => 'test2@demo.com',
            'mobile' => '123456789000',
            'room_number' => '1234',
            'start_time' => '13:00',
            'end_time' => '15:00',
            'slot' => 1,
            'qty' => 1,
            'status' => 'confirmed',
        ]);

    }

    public function test_it_will_update_a_basic_calendar_booking(){
        $this->refreshDatabase();
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
        $product->specifics()->create(['name' => 'available_saturday', 'value' => '1']);
        $product->specifics()->create(['name' => 'start_time_saturday', 'value' => '09:00']);
        $product->specifics()->create(['name' => 'end_time_saturday', 'value' => '17:00']);
        $image = UploadedFile::fake()->image('product.jpg');
        $variant = $product->variations()->create(['image' => $image, 'name' => 'Original Variant', 'price' => 50]);

        $response = $this->actingAs($user)->post(route('calendar.store-booking', ['hotel_id' => $hotel->id, 'product_id' => $product->id]), [
                'name' => 'John Doe',
                'email' => 'test@example.com',
                'phone' => '1234567890',
                'room' => '123',
                'date' => '2025-01-25',
                'start_time' => '09:00:00',
                'end_time' => '11:00:00',
                'slot' => 1,
                'qty' => 1,
                'status' => 'confirmed',
            ]
        );

        $response->assertStatus(302);

        $booking = CalendarBooking::first();


        $response = $this->actingAs($user)->post(route('calendar.update-booking'), [
            'booking_id' => $booking->id,
            'name' => 'Jane Doeson',
            'email' => 'test1@demo.com',
            'phone' => '123456789000',
            'room' => '123456',
            'date' => '2025-01-25',
            'start_time' => '15:00:00',
            'end_time' => '17:00:00',
            'slot' => 1,
            'qty' => 1,
            'status' => 'confirmed',
        ]);

        $this->assertDatabaseHas('calendar_bookings', [
            'product_id' => $product->id,
            'variation_id' => $variant->id,
            'name' => 'Jane Doeson',
            'email' => 'test1@demo.com',
            'mobile' => '123456789000',
            'room_number' => '123456',
            'start_time' => '15:00',
            'end_time' => '17:00',
            'slot' => 1,
            'qty' => 1,
            'status' => 'confirmed',
        ]);

    }
}
