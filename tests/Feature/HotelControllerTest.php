<?php
namespace Tests\Feature;

use App\Models\Hotel;
use App\Models\Connection;
use http\Client\Curl\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HotelControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_displays_the_welcome_page_with_valid_hotel_id()
    {
        $user = \App\Models\User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        // Provide the necessary form data to avoid the redirect
        $data = [
            'name' => 'John Doe',
            'arrival_date' => '2024-12-10',
            'departure_date' => '2024-12-15',
            'email_address' => 'john.doe@example.com',
        ];

        // Passing the data as query parameters
        $response = $this->get(route('hotel.welcome', ['id' => $hotel->id]) . '?' . http_build_query($data));

        // Assert that the response status is 200
        $response->assertStatus(302);

        $response->assertSessionHas('name', 'John Doe');
        $response->assertSessionHas('arrival_date', '2024-12-10');
        $response->assertSessionHas('departure_date', '2024-12-15');
        $response->assertSessionHas('email_address', 'john.doe@example.com');
    }



    /** @test */
    public function it_displays_the_welcome_page_with_valid_hotel_slug()
    {

        $this->refreshDatabase();

        $user = \App\Models\User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('hotel.welcome', ['id' => $hotel->slug]));

        // Assert the response is a redirect (302)
        $response->assertStatus(302);

        // Get the redirect URL from the response
        $redirectUrl = $response->headers->get('Location');

        // Follow the redirect to the hotel dashboard
        $response = $this->get($redirectUrl);

        // Assert that the final response status is 200
        $response->assertStatus(200);
        $response->assertViewIs('hotel.dashboard');
        $response->assertViewHas('hotel', $hotel);
    }

    /** @test */
    public function it_redirects_to_dashboard_if_all_required_data_is_not_present()
    {
        $user = \App\Models\User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('hotel.welcome', ['id' => $hotel->slug, 'name' => 'John']));

        $response->assertRedirect(route('hotel.dashboard', ['id' => $hotel->slug]));
    }

    /** @test */
    public function it_creates_a_new_hotel_and_redirects_to_edit_page()
    {
        $this->refreshDatabase();
        // Fake a User
        $user = \App\Models\User::factory()->create();

        // Fake the data
        $data = [
            'name' => 'Test Hotel',
            'address' => '123 Test Street',
            'logo' => UploadedFile::fake()->image('logo.jpg'),
            'featured_image' => UploadedFile::fake()->image('featured_image.jpg')
        ];

        // Ensure CSRF token is included
        $response = $this->actingAs($user)
            ->withSession(['banned' => false])
            ->post(route('hotel.store'), $data);

        $hotel = Hotel::latest()->first();

        $this->assertEquals($data['name'], $hotel->name);
        $this->assertEquals($data['address'], $hotel->address);
        $response->assertRedirect(route('hotel.edit', ['id' => $hotel->id]));
    }


    /** @test */
    public function it_shows_the_edit_page_for_the_hotel()
    {
        $user = \App\Models\User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('hotel.edit', ['id' => $hotel->id]));
        // Assert the response is a redirect (302)

        // Get the redirect URL from the response

        // Follow the redirect to the hotel dashboard
        $response->assertStatus(200);
        $response->assertViewIs('admin.hotel.edit');
        $response->assertViewHas('hotel', $hotel);
    }

    /** @test */
    public function it_prevents_non_owner_users_from_editing_the_hotel()
    {
        $user = \App\Models\User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $this->actingAs(\App\Models\User::factory()->create()); // Simulate another user

        $response = $this->get(route('hotel.edit', ['id' => $hotel->id]));

        $response->assertRedirect(route('dashboard'));
    }

    /** @test */
    public function it_updates_the_hotel_and_redirects_to_edit_page()
    {
        $user = \App\Models\User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $data = [
            'name' => 'Updated Hotel Name',
            'address' => '456 New Street',
            'logo' => UploadedFile::fake()->image('new_logo.jpg'),
        ];


        $response = $this->actingAs($user)->post(route('hotel.update', ['id' => $hotel->id]), $data);


        $hotel->refresh();

        $this->assertEquals($data['name'], $hotel->name);
        $this->assertEquals($data['address'], $hotel->address);
        $response->assertRedirect(route('hotel.edit', ['id' => $hotel->id]));
    }

    /** @test */
    public function it_creates_or_updates_resdiary_microsite_name()
    {
        $user = \App\Models\User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $data = ['resdiary_microsite_name' => 'new-microsite-name'];

        $response = $this->actingAs($user)->post(route('hotel.update', ['id' => $hotel->id]), $data);

        $this->assertDatabaseHas('connections', [
            'hotel_id' => $hotel->id,
            'key' => 'resdiary_microsite_name',
            'value' => 'new-microsite-name',
        ]);
    }

    /** @test */
    public function it_shows_the_dashboard_with_hotel_data_and_cart()
    {
        $user = \App\Models\User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);

        $cart = ['product_id' => 1, 'quantity' => 2];

        session(['cart' => $cart]);

        $response = $this->actingAs($user)->get(route('hotel.dashboard', ['id' => $hotel->slug]));

        $response->assertStatus(200);
        $response->assertViewIs('hotel.dashboard');
        $response->assertViewHas('hotel', $hotel);
        $response->assertViewHas('cart', $cart);
    }
}

