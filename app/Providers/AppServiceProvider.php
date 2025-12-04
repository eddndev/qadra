<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Hearing;
use App\Models\Tenant;
use App\Observers\HearingObserver;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tell Cashier to use Tenant model instead of User
        Cashier::useCustomerModel(Tenant::class);
        
        Hearing::observe(HearingObserver::class);
    }
}