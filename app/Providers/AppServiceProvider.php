<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Hearing;
use App\Observers\HearingObserver;

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
        Hearing::observe(HearingObserver::class);
    }
}
