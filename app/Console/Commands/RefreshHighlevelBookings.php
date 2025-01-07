<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Console\Command;
use App\Services\HotelBookings\HotelBookingsService;
use Carbon\Carbon;

class RefreshHighlevelBookings extends Command
{
    // The name and signature of the console command
    protected $signature = 'bookings:refresh';

    // The console command description
    protected $description = 'Refresh all future bookings where the guest hasnt signed in yet';

    // Create a new command instance
    public function __construct()
    {
        parent::__construct();
    }

    // Execute the console command
    // Will only update bookings where checkin is null
    public function handle()
    {
        $config =
            [
                "apiKey" => env("HLS_API_KEY"),
                "host" => env("HLS_HOST"),
                //"host" => "https://api.high-level-software.com"
                "token" => env("HLS_TOKEN"),
                "secret" => env("HLS_SECRET"),
            ];
            $HotelBookingsService = new HotelBookingsService($config);
            foreach ($HotelBookingsService->fetchReservations() as $Reservation) {
                // Find hotel id
                $Booking = Booking::where("booking_ref", $Reservation->externalBookingId)->where("checkin", null)->first();
                if ($Booking != null) {
                    $dateTime = null;
                    if($Reservation->checkedInString!=null)
                        $dateTime = Carbon::parse($Reservation->checkedInString);
                    $Booking->room = $Reservation->roomNumber;
                    $Booking->checkin = $dateTime?->toDateTimeString();
                    $Booking->save();
                }
            }

    }
}
