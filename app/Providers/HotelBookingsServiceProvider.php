<?php

namespace App\Providers;

use App\Services\HighlevelBookingsAPI;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Foundation\Application;

class HotelBookingsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(HighlevelBookingsAPI::class, function (Application $app) {
            return new HighlevelBookingsAPI($app['config']['hotelbookingapis']);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
