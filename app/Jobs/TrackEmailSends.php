<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TrackEmailSends implements ShouldQueue
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
    public function handle(): void
    {
        \DB::table('email_analytics')->updateOrInsert(
            [
                'hotel_id' => $this->hotelId,
                'sent_date' => now()->toDateString(),
            ],
            ['email_count' => \DB::raw('email_count + 1')]
        );
    }
}
