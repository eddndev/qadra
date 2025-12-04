<?php

namespace App\Livewire\Billing;

use App\Models\Tenant;
use Livewire\Component;
use Laravel\Cashier\Cashier;

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

        // Redirect to Stripe Checkout
        $checkout = $tenant->newSubscription('default', $priceId)
            ->trialDays(30) // Optional: Force trial or rely on DB logic
            ->allowPromotionCodes()
            ->checkout([
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
        return $tenant->redirectToBillingPortal(route('billing.index'));
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