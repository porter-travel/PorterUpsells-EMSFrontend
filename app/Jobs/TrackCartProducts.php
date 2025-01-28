<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackCartProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $hotelId;

    public $productId;

    public $variantId;

    /**
     * Create a new job instance.
     */
    public function __construct($hotelId, $productId, $variantId)
    {

        $this->hotelId = $hotelId;

        $this->productId = $productId;

        $this->variantId = $variantId;

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        \DB::table('hotel_analytics')->updateOrInsert(
            [
                'hotel_id' => $this->hotelId,
                'product_id' => $this->productId,
                'variation_id' => $this->variantId,
                'view_date' => now()->toDateString(),
            ],
            ['added_to_cart_count' => \DB::raw('added_to_cart_count + 1')]
        );
    }
}
