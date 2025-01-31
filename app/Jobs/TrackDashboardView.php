<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackDashboardView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $hotelId;

    /**
     * Create a new job instance.
     */
    public function __construct($hotelId)
    {
        $this->hotelId = $hotelId;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $existingRecord = \DB::table('hotel_analytics')
            ->where('hotel_id', $this->hotelId)
            ->where('view_date', now()->toDateString())
            ->first();

        if ($existingRecord) {
            \DB::table('hotel_analytics')
                ->where('hotel_id', $this->hotelId)
                ->where('view_date', now()->toDateString())
                ->increment('dashboard_views');
        } else {
            \DB::table('hotel_analytics')->insert([
                'hotel_id' => $this->hotelId,
                'view_date' => now()->toDateString(),
                'dashboard_views' => 1,
            ]);
        }
    }

}
