<?php

namespace App\Livewire\Billing;

use App\Models\Tenant;
use Livewire\Component;
use Laravel\Cashier\Cashier;
use Illuminate\Support\Carbon;

class BillingPortal extends Component
{
    public $interval = 'monthly'; // monthly | yearly

    public function mount()
    {
        // Ensure only Owner can access
        // Ideally handled by middleware/policy, but double check here
        // if (auth()->user()->role !== 'owner') abort(403); 
    }

    /**
     * Start a new subscription checkout session
     */
    public function subscribe($plan, $interval)
    {
        $tenant = Tenant::getGlobalTenant();
        
        // Resolve Stripe Price ID from config
        $configKey = "services.stripe.plans.{$plan}.{$interval}";
        $priceId = config($configKey);

        if (!$priceId) {
            session()->flash('error', 'Error de configuración: Precio no encontrado.');
            return;
        }

        // Build subscription
        $subscriptionBuilder = $tenant->newSubscription('default', $priceId)
            ->allowPromotionCodes();

        // If tenant is still on trial, respect the remaining days
        if ($tenant->onTrial()) {
            $trialEnds = $tenant->trial_ends_at;
            $subscriptionBuilder->trialUntil($trialEnds);
        } else {
            // Optional: If you want to give a fresh 30 days trial ONLY if they never had one
            // $subscriptionBuilder->trialDays(30); 
            // But since we give trial on registration, we skip this to avoid double dipping.
        }

        // Redirect to Stripe Checkout
        $checkout = $subscriptionBuilder->checkout([
            'success_url' => route('billing.index') . '?success=true',
            'cancel_url' => route('billing.index') . '?cancel=true',
        ]);

        return redirect($checkout->asStripeCheckoutSession()->url);
    }

    /**
     * Redirect to Stripe Self-Serve Portal (Update card, invoices, cancel)
     */
    public function manage()
    {
        $tenant = Tenant::getGlobalTenant();
        $url = $tenant->billingPortalUrl(route('billing.index'));
        return redirect($url);
    }

    public function render()
    {
        $tenant = Tenant::getGlobalTenant();
        
        // Check subscription status
        $isSubscribed = $tenant->subscribed('default');
        $currentPlan = null;
        
        if ($isSubscribed) {
            // Determine plan name based on price ID
            $priceId = $tenant->subscription('default')->stripe_price;
            
            if ($priceId === config('services.stripe.plans.starter.monthly') || 
                $priceId === config('services.stripe.plans.starter.yearly')) {
                $currentPlan = 'Starter';
            } elseif ($priceId === config('services.stripe.plans.professional.monthly') || 
                      $priceId === config('services.stripe.plans.professional.yearly')) {
                $currentPlan = 'Professional';
            } else {
                $currentPlan = 'Personalizado';
            }
        }

        return view('livewire.billing.billing-portal', [
            'tenant' => $tenant,
            'isSubscribed' => $isSubscribed,
            'currentPlan' => $currentPlan,
            'onTrial' => $tenant->onTrial(),
        ])->layout('layouts.app', ['header' => 'Facturación y Suscripción']);
    }
}
