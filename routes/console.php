<?php

use App\Console\Commands\ListBookings;
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

Schedule::command('emails:send-scheduled')
    ->everyMinute()
    ->description('Send scheduled emails.');

Schedule::command('bookings:fetch')
    ->hourly()
    ->description('Check for new bookings.');

Schedule::command('bookings:refresh')
    ->everyTenMinutes()
    ->description('Refresh bookings to updated checkin.');
