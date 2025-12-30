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

        // Customize Email Verification URL to match Tenant Subdomain
        \Illuminate\Auth\Notifications\VerifyEmail::createUrlUsing(function ($notifiable) {
            $frontendUrl = config('app.url');
            $tenant = null;

            if (method_exists($notifiable, 'tenants')) {
                $tenant = $notifiable->tenants->sortByDesc('created_at')->first();
            }

            if ($tenant) {
                $centralDomain = parse_url($frontendUrl, PHP_URL_HOST) ?? $frontendUrl;
                $protocol = request()->secure() ? 'https://' : 'http://';
                $frontendUrl = $protocol . $tenant->slug . '.' . $centralDomain;
            } else {
                // IMPORTANT: For tenantless users, ensure we use the APP_URL (Central Domain)
                // This prevents signature mismatches if the request originated from a different context
                $frontendUrl = config('app.url');
            }

            // Temporarily force root URL to generate correct signature
            $originalRoot = \Illuminate\Support\Facades\URL::formatRoot('', '');
            \Illuminate\Support\Facades\URL::forceRootUrl($frontendUrl);

            $verifyUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                'verification.verify',
                now()->addMinutes(config('auth.verification.expire', 60)),
                [
                    'id' => $notifiable->getKey(),
                    'hash' => sha1($notifiable->getEmailForVerification()),
                ]
            );

            // Restore original root
            \Illuminate\Support\Facades\URL::forceRootUrl($originalRoot);

            return $verifyUrl;
        });
    }
}