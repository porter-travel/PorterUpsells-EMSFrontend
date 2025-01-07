<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Hotel;
use Illuminate\Console\Command;
use App\Services\HotelBookings\HotelBookingsService;
use Carbon\Carbon;

class FetchHighlevelBookings extends Command
{
    // The name and signature of the console command
    protected $signature = 'bookings:fetch';

    // The console command description
    protected $description = 'Fetch last 15 and next 15 days bookings';

    // Create a new command instance
    public function __construct()
    {
        parent::__construct();
    }

    // Execute the console command
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
            $hotelExternalId = $Reservation->hotelId;
            $Hotel = Hotel::where("id_for_integration", $hotelExternalId)->first();
            if($Hotel==null)
                continue(1);
            // Check have we already got it
            $Booking = Booking::where("booking_ref", $Reservation->externalBookingId)->first();
            if ($Booking == null) {
                $dateTime = null;
                if($Reservation->checkedInString!=null)
                    $dateTime = Carbon::parse($Reservation->checkedInString);
                $Booking = new Booking(
                    [
                        'hotel_id' => $Hotel->id,
                        'name' => $Reservation->name,
                        'email_address' => $Reservation->email,
                        'arrival_date' => $Reservation->HotelDates->checkinString,
                        'departure_date' => $Reservation->HotelDates->checkoutString,
                        'booking_ref' => $Reservation->externalBookingId,
                        'room' => $Reservation->roomNumber,
                        'checkin' => $dateTime?->toDateTimeString(),
                    ]
                );

                $Booking->save();
            }
        }
    }
}
