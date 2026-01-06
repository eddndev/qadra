<?php

namespace App\Nova\Metrics;

use DateTimeInterface;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Partition;
use Laravel\Nova\Metrics\PartitionResult;

class TenantsPerTier extends Partition
{
    /**
     * Calculate the value of the metric.
     */
    public function calculate(NovaRequest $request)
    {
        return $this->count($request, \App\Models\Tenant::class, 'subscription_tier_id')
            ->label(function ($value) {
                if (!$value)
                    return 'Sin Plan';
                return \App\Models\SubscriptionTier::find($value)?->name ?? 'Desconocido';
            });
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     */
    public function cacheFor(): DateTimeInterface|null
    {
        // return now()->addMinutes(5);

        return null;
    }

    /**
     * Get the URI key for the metric.
     */
    public function uriKey(): string
    {
        return 'tenants-per-tier';
    }
}
