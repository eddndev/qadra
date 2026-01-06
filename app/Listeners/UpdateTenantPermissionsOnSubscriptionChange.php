<?php

namespace App\Listeners;

use Laravel\Cashier\Events\SubscriptionUpdated;
use Laravel\Cashier\Events\SubscriptionCreated;
use App\Services\TenantService;
use App\Models\Tenant;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateTenantPermissionsOnSubscriptionChange implements ShouldQueue
{
    use InteractsWithQueue;

    protected TenantService $tenantService;

    public function __construct(TenantService $tenantService)
    {
        $this->tenantService = $tenantService;
    }

    /**
     * Handle the event.
     * We support both SubscriptionCreated and SubscriptionUpdated.
     * Note: Cashier events pass the 'subscription' object. We need to find the tenant processing it.
     */
    public function handle($event): void
    {
        // Event payload depends on class, but both usually have $subscription property.
        $subscription = $event->subscription;

        // Cashier subscriptions belong to a billable model. In our case, Tenant.
        // We can access it via $subscription->owner (if loaded) or query it.
        $tenant = $subscription->owner;

        if (!$tenant || !($tenant instanceof Tenant)) {
            Log::warning("Subscription event {$subscription->id} has no valid Tenant owner.");
            return;
        }

        Log::info("Subscription changed for Tenant {$tenant->name} ({$tenant->id}). Syncing permissions...");
        
        // We might need to refresh the tenant's subscription tier association if it was just changed.
        // However, Cashier updates the 'stripe_price' on the subscription table.
        // Our 'subscription_tier_id' on the tenants table might be out of sync if we rely solely on webhook.
        // Typically, we should update the local tier_id based on the new stripe_price ID.
        
        $this->updateLocalTier($tenant, $subscription->stripe_price);

        // Now sync permissions
        $this->tenantService->syncPermissions($tenant);
    }

    protected function updateLocalTier(Tenant $tenant, string $stripePriceId)
    {
        // Find which tier matches this price ID (monthly or yearly)
        // We use config('services.stripe.plans...')
        
        $tiers = \App\Models\SubscriptionTier::all();
        $matchedTier = null;

        // Naive check against config (assuming config reflects DB tiers)
        // Or check price amounts? Better to trust config mapping if that's the source of truth for IDs.
        
        foreach ($tiers as $tier) {
            $monthlyId = config("services.stripe.plans.{$tier->slug}.monthly");
            $yearlyId = config("services.stripe.plans.{$tier->slug}.yearly");

            if ($stripePriceId === $monthlyId || $stripePriceId === $yearlyId) {
                $matchedTier = $tier;
                break;
            }
        }

        if ($matchedTier) {
            $tenant->update(['subscription_tier_id' => $matchedTier->id]);
            Log::info("Updated Tenant {$tenant->id} local tier to {$matchedTier->slug}");
        } else {
            Log::warning("Could not match Stripe PRICE ID {$stripePriceId} to any local tier.");
        }
    }
}
