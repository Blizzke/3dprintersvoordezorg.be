<?php

namespace App\Providers;

use App\Customer;
use App\Helper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Route::bind('order', function ($value) {
            return \App\Order::whereIdentifier($value)->with('customer', 'helper')->firstOrFail();
        });

        Route::bind('customer', function ($value) {
            return Customer::whereIdentifier($value)->firstOrFail();
        });

        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('d/m/Y H:i'); ?>";
        });

        Blade::directive('is_helper', function () {
            return Auth::user() instanceof Helper;
        });

        Blade::directive('is_customer', function () {
            return Auth::user() instanceof Customer;
        });

    }
}
