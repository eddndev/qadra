<?php

namespace App\Policies;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TenantPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tenant $tenant): bool
    {
        return $user->belongsToTenant($tenant);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tenant $tenant): bool
    {
        return $user->belongsToTenant($tenant) && $user->hasPermissionTo('settings.edit');
    }

    /**
     * Determine whether the user can manage billing.
     */
    public function manageBilling(User $user, Tenant $tenant): bool
    {
        return $user->belongsToTenant($tenant) && $user->hasPermissionTo('subscription.manage');
    }
}