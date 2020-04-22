<?php

namespace App\Providers;

use App\Customer;
use App\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Schema\Builder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

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
        // Fix SQLSTATE[42000]: Syntax error or access violation: 1071 Specified key was too long; max key length is 1000 bytes
        Builder::defaultStringLength(191);

        Route::bind('order', function ($value) {
            try {
                return Order::whereIdentifier($value)->with('customer', 'helper')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                throw new AccessDeniedHttpException('Ongeldige gegevens');
            }
        });

        Route::bind('customer', function ($value) {
            try {
                return Customer::whereIdentifier($value)->firstOrFail();
            } catch (ModelNotFoundException $e) {
                throw new AccessDeniedHttpException('Ongeldige gegevens');
            }
        });
    }
}
