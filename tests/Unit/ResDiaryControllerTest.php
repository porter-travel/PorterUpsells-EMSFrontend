<?php

namespace Tests\Unit;

use App\Http\Controllers\ResDiaryController;
use App\Models\Connection;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;
use App\Models\User;

class ResDiaryControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_install_redirects_to_authorization_url()
    {
        // Arrange
        $request = Request::create('/install', 'GET', [
            'authorization_uri' => 'https://example.com/auth?client_id=123'
        ]);
        $controller = new ResDiaryController();

        // Act
        $response = $controller->install($request);

        // Assert
        $this->assertInstanceOf(\Illuminate\Http\RedirectResponse::class, $response);
        $this->assertStringContainsString('https://example.com/auth?client_id=123', $response->getTargetUrl());
        $this->assertStringContainsString('code_challenge=', $response->getTargetUrl());
    }


    public function test_callback_handles_successful_token_exchange()
    {
        // Arrange
        $user = $this->createUserWithHotels(1);
        $this->actingAs($user);

        // Store session values
        Session::put('code_verifier', 'test_code_verifier');
        Session::put('code_challenge', 'test_code_challenge');

        // Fake the response from ResDiary token URL
        Http::fake([
            env('RESDIARY_TOKEN_URL') => Http::response([
                'access_token' => 'access_token_test',
                'refresh_token' => 'refresh_token_test',
            ], 200),
        ]);

        // Simulate the request
        $request = Request::create('/callback', 'GET', [
            'code' => 'test_code',
        ]);
        $controller = new ResDiaryController();

        // Act
        $response = $controller->callback($request);

        // Assert
        // Since $response is a View instance, use the `assertViewIs` method directly
        $this->assertInstanceOf(\Illuminate\View\View::class, $response); // Ensure it's a View instance
        $this->assertEquals('admin.resdiary.callback', $response->name()); // Check the view name

        // Check that the database contains the new connections
        $this->assertDatabaseHas('connections', [
            'key' => 'resdiary_access_token',
            'value' => 'access_token_test',
        ]);
        $this->assertDatabaseHas('connections', [
            'key' => 'resdiary_refresh_token',
            'value' => 'refresh_token_test',
        ]);
    }




    public function test_setHotel_saves_tokens_to_connections()
    {
        // Arrange
        Session::put('resdiary_access_token', 'access_token_test');
        Session::put('resdiary_refresh_token', 'refresh_token_test');

        $user = User::factory()->create();
        $hotel = Hotel::factory()->create([
            'user_id' => $user->id,
        ]);
        $request = Request::create('/set-hotel', 'POST', [
            'hotel_id' => $hotel->id,
        ]);
        $controller = new ResDiaryController();

        // Act
        $response = $controller->setHotel($request);

        // Assert
        $this->assertInstanceOf(\Illuminate\View\View::class, $response); // Ensure it's a View instance
        $this->assertEquals('admin.resdiary.callback', $response->name()); // Check the view name
        $this->assertDatabaseHas('connections', [
            'hotel_id' => $hotel->id,
            'key' => 'resdiary_access_token',
            'value' => 'access_token_test',
        ]);
        $this->assertDatabaseHas('connections', [
            'hotel_id' => $hotel->id,
            'key' => 'resdiary_refresh_token',
            'value' => 'refresh_token_test',
        ]);
    }

    public function test_getAvailability_returns_availability_data()
    {
        // Arrange
        $user = User::factory()->create();
        $hotel = Hotel::factory()->create(['user_id' => $user->id]);
        Connection::factory()->create([
            'hotel_id' => $hotel->id,
            'key' => 'resdiary_access_token',
            'value' => 'test_access_token',
        ]);
        Connection::factory()->create([
            'hotel_id' => $hotel->id,
            'key' => 'resdiary_microsite_name',
            'value' => 'test_microsite',
        ]);

        // Mock the Availability service to mock the response
        $mockAvailabilityService = Mockery::mock('App\Services\ResDiary\Availability');
        $mockAvailabilityService->shouldReceive('getAvailability')
            ->with('test_access_token', 'test_microsite', '2024-11-15', 2)
            ->andReturn(['availability' => 'test_data']);
        $this->app->instance('App\Services\ResDiary\Availability', $mockAvailabilityService);

        $request = Request::create('/get-availability', 'GET', [
            'hotel_id' => $hotel->id,
            'date' => '2024-11-15',
            'party_size' => 2,
        ]);
        $controller = new ResDiaryController(true);

        // Act
        $response = $controller->getAvailability($request);

        // Assert
        $this->assertEquals(200, $response->status()); // Alternatively, check the status code with assertEquals
    }


    public function createUserWithHotels(int $numHotels = 1)
    {
        // Create a user
        $user = User::factory()->create();

        // Create hotels and associate them with the user
        Hotel::factory()->count($numHotels)->create([
            'user_id' => $user->id,
        ]);

        return $user;
    }
}




