<?php

namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\Product;
use App\Models\ProductSpecific;
use App\Models\User;
use App\Models\Variation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_stores_hotel_id_in_session_and_returns_view()
    {
        // Create a User
        $user = User::factory()->create();

        // Create a Hotel associated with the User
        $hotel = Hotel::factory()->create([
            'user_id' => $user->id,
        ]);

        Session::start(); // Initialize session

// Act
        $response = $this->get(route('cart.show', ['hotel_id' => $hotel->id]));

// Assert
        $response->assertStatus(200);
        $response->assertViewIs('cart.show');
        $response->assertSessionHas('hotel_id', $hotel->id);
    }

    public function test_add_to_cart_adds_items_correctly()
    {
// Arrange
        // Create a User
        $user = User::factory()->create();

        // Create a Hotel associated with the User
        $hotel = Hotel::factory()->create([
            'user_id' => $user->id,
        ]);
        $product = Product::factory()->create([
            'hotel_id' => $hotel->id,
        ]);
        $variation = Variation::factory()->create(
            ['price' => 100, 'product_id' => $product->id]
        );
        $productSpecific = ProductSpecific::factory()->create([
            'product_id' => $product->id,
            'name' => 'requires_resdiary_booking',
            'value' => 1,
        ]);
        Session::start(); // Start session for POST request

        $payload = [
            'formObj' => [
                'variation_id' => $variation->id,
                'quantity' => 2,
                'product_id' => $variation->id,
                'hotel_id' => $hotel->id,
                'arrival_time' => '10:00',
                'product_name' => 'Test Product',
                'product_type' => 'room',
                'dates[]' => ['2024-12-10'],
                'resdiary_promotion_id' => '123',
            ]
        ];

// Act
        $response = $this->post(route('cart.add'), $payload);

// Assert
        $response->assertStatus(200);
        $cart = session('cart');
        $this->assertArrayHasKey("{$variation->id}-{$variation->id}-10:00", $cart);
        $this->assertEquals(2, $cart["{$variation->id}-{$variation->id}-10:00"]['quantity']);
    }

    public function test_remove_from_cart_removes_item()
    {
        // Arrange
        $cartItemId = 'product-1';
        session()->put('cart', [
            $cartItemId => ['quantity' => 1, 'price' => 100],
            'product-2' => ['quantity' => 2, 'price' => 200],
        ]);

        // Act
        $response = $this->post(route('cart.remove', ['id' => $cartItemId]));

        // Assert
        $response->assertStatus(200);

        // Check the key 'product-1' is not in the session 'cart'
        $this->assertArrayNotHasKey($cartItemId, session('cart'));

        // Optionally, ensure other items in the cart are still intact
        $this->assertArrayHasKey('product-2', session('cart'));
    }

    public function test_delete_cart_if_expired_removes_cart()
    {
// Arrange
        Session::put('cart', [
            'expiry' => now()->subMinutes(5)->timestamp,
        ]);

// Act
        $this->get(route('cart.show', ['hotel_id' => 1]));

// Assert
        $this->assertNull(session('cart'));
    }

    public function test_update_cart_qty_updates_quantity()
    {
// Arrange
        $cartItemId = 'product-1';
        Session::put('cart', [$cartItemId => ['quantity' => 1, 'price' => 100]]);

// Act
        $response = $this->post(route('cart.update', ['id' => $cartItemId]), ['quantity' => 5, 'price' => 100]);

// Assert
        $response->assertStatus(200);
        $cart = session('cart');
        $this->assertEquals(5, $cart[$cartItemId]['quantity']);
    }
}
