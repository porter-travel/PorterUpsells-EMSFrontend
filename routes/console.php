<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();



Schedule::command('orders:send-hotel-email-summary')
    ->dailyAt('21:00')
//        ->everyMinute()
    ->timezone('Europe/London')
    ->description('Send the hotel email summary for the day.');
