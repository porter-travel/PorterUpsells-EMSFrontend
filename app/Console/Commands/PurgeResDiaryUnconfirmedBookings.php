<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Hotel;
use App\Services\ResDiary\ResDiaryBooking;
use Illuminate\Console\Command;
use App\Services\HotelBookings\HotelBookingsService;
use Carbon\Carbon;

class PurgeResDiaryUnconfirmedBookings extends Command
{
    // The name and signature of the console command
    protected $signature = 'resdiary:purge-unconfirmed';

    // The console command description
    protected $description = 'Remove Unconfirmed ResDiary bookings older than 2 hours';

    // Create a new command instance
    public function __construct()
    {
        parent::__construct();
    }

    // Execute the console command
    public function handle()
    {
        $orders_resdiary = Booking::where('status', 'unconfirmed')->where('created_at', '<', Carbon::now()->subHours(2))->get();
        foreach ($orders_resdiary as $order) {
            ResDiaryBooking::deleteBooking($order);
        }
    }
}
