<?php

namespace App\Providers;

use App\Services\HotelBookings\HotelBookingsService;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
        $this->app->bind(HotelBookingsService::class, function() {
            $config = Config::get('app.hotelbookingapis.highlevel');
            return new HotelBookingsService($config);
          });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('checked', function ($expression) {
            return "<?php echo isset($expression) && $expression ? 'checked' : ''; ?>";
        });
    }
}
