<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\CustomerEmailController;
use App\Services\HotelBookings\Highlevel\HotelBookingsHighlevel;
use Carbon\Carbon;

class ListBookings extends Command
{
// The name and signature of the console command
    protected $signature = 'bookings:list';

// The console command description
    protected $description = 'Show bookings';

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
            "apiKey" => "3f3WkVeHuF1iwxTxeC8vn7oZYm00U3gu7d9jx6TQ",
            "host" => "https://api.stage.dev.high-level-software.com",
            //"host" => "https://api.high-level-software.com"
            "token" => "e57ab82f1d2c9c43",
            "secret" => "6453fd736fea0b6190e27331a318a8f39da15d41013474417a78cf96858d8a2b"
        ];
        $HotelBookingsHighlevel = new HotelBookingsHighlevel($config);
      
    }
}
