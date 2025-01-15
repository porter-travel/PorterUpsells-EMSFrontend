<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class CreateHotelTest extends DuskTestCase
{

    use DatabaseTruncation;

    /**
     * A Dusk test example.
     */
    public function testUserCanCreateHotel(): void
    {

        $user = User::factory()->create([
            'email' => 'hotel@example.com',
            'password' => bcrypt('password'), // Ensure the password is hashed
        ]);

        $this->browse(function (Browser $browser) use ($user) {

            //Create a hotel
            $browser->loginAs($user->id)
                ->visit('/admin/hotel/create')
                ->type('@hotel-name', 'Hotel Name')
                ->type('@hotel-address', 'Hotel Address')
                ->attach('@hotel-logo', public_path() . '/img/icons/plus.svg')
                ->click('@create-hotel')
                ->assertPathBeginsWith('/admin/hotel/')
                ->assertPathEndsWith('/edit');

            //Check if the hotel was created
            $browser->assertSee('HOTEL NAME')
                ->assertInputValue('address', 'Hotel Address')
                ->assertInputValue('email_address', '');


        });
    }
}
