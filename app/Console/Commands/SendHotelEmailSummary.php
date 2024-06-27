<?php

namespace App\Console\Commands;

use App\Mail\HotelOrderSummary;
use App\Models\Hotel;
use App\Services\OrderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendHotelEmailSummary extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:send-hotel-email-summary {--hotel_id=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sends the hotel email summary for the day.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if($this->option('hotel_id') === 'all') {
            $hotels = Hotel::all();
            foreach($hotels as $hotel) {
                if($hotel->email_address)
                    Mail::to($hotel->email_address)->send(new HotelOrderSummary($hotel));
            }
            return;
        }
        $hotelId = $this->option('hotel_id');
        $hotel = Hotel::find($hotelId);
        Mail::to($hotel->email_address)->send(new HotelOrderSummary($hotel));
    }
}
