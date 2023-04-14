<?php

namespace App\Providers;

use App\Models\Subscribers;
use Stripe\StripeClient;
use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

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
        Cashier::useCustomerModel(Subscribers::class);
        // $this->app->singleton(StripeClient::class, function() {
        //     return new StripeClient(env('STRIPE_SECRET'));
        // });
    }
}
