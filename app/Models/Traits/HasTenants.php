<?php

namespace App\Models\Traits;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasTenants
{
    /**
     * The tenants that the user belongs to.
     */
    public function tenants(): BelongsToMany
    {
        return $this->belongsToMany(Tenant::class, 'tenant_user')
            ->withPivot(['role', 'permissions', 'is_active', 'joined_at'])
            ->withTimestamps();
    }

    /**
     * Check if the user belongs to the given tenant.
     */
    public function belongsToTenant(Tenant $tenant): bool
    {
        return $this->tenants->contains($tenant);
    }
    
    /**
     * Get the user's role in a specific tenant.
     */
    public function roleIn(Tenant $tenant): ?string
    {
        $record = $this->tenants->find($tenant->id);
        return $record ? $record->pivot->role : null;
    }
}
