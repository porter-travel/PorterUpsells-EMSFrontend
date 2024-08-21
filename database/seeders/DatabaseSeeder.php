<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\Hotel;
use App\Models\Product;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Variation;
use Database\Factories\HotelFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'alex@gluestudio.co.uk',
            'password' => 'password',
        ]);


        // integration id 82cb4c8c-fd81-11ee-baef-02a3e6f84031
        Hotel::factory(10)
            ->has(Product::factory()
                ->has(Variation::factory()->count(3))
                ->count(3))
            ->create();
        
        //Booking::factory(5)->create();

    }
}
