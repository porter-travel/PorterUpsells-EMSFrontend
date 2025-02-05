<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackCartView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $hotelId;

    public function __construct($hotelId)
    {
        $this->hotelId = $hotelId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        \DB::table('hotel_analytics')->updateOrInsert(
            [
                'hotel_id' => $this->hotelId,
                'view_date' => now()->toDateString(),
            ],
            ['cart_views' => \DB::raw('cart_views + 1')]
        );
    }

}
