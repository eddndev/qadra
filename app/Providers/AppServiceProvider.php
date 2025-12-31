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
            $frontendUrl = rtrim(config('app.url'), '/');
            $tenant = null;

            if (method_exists($notifiable, 'tenants')) {
                $tenant = $notifiable->tenants->sortByDesc('created_at')->first();
            }

            \Illuminate\Support\Facades\Log::info('VerifyEmail Gen: Start', ['user_id' => $notifiable->getKey(), 'has_tenants_trait' => method_exists($notifiable, 'tenants')]);

            if ($tenant) {
                \Illuminate\Support\Facades\Log::info('VerifyEmail Gen: Tenant Found', ['slug' => $tenant->slug]);
                $centralDomain = parse_url($frontendUrl, PHP_URL_HOST) ?? $frontendUrl;
                $protocol = request()->secure() ? 'https://' : 'http://';
                $frontendUrl = $protocol . $tenant->slug . '.' . $centralDomain;
            } else {
                \Illuminate\Support\Facades\Log::info('VerifyEmail Gen: No Tenant Found (using central)');
                // $frontendUrl is already config('app.url') trimmed
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

            \Illuminate\Support\Facades\Log::info('VerifyEmail Gen: Final URL', ['url' => $verifyUrl]);

            return $verifyUrl;
        });
    }
}