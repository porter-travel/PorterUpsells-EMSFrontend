<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackProductView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public $hotelId;
    public $productId;

    public function __construct($hotelId, $productId)
    {
        $this->hotelId = $hotelId;
        $this->productId = $productId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        \DB::table('product_views')->updateOrInsert(
            [
                'hotel_id' => $this->hotelId,
                'product_id' => $this->productId,
                'view_date' => now()->toDateString(),
            ],
            ['views' => \DB::raw('views + 1')]
        );
    }

}
