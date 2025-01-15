<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{

    use DatabaseTruncation;

    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->artisan('config:clear');
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'), // Ensure the password is hashed
        ]);

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/login')
                ->type('email', $user->email)
                ->type('password', 'password')
                ->press('@login-button')
                ->assertPathIs('/dashboard');
        });
    }
}
