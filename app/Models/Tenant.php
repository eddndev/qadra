<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Cashier\Billable;

class Tenant extends Model
{
    use HasFactory, HasUlids, SoftDeletes, Billable;

    // Static property to hold the globally identified tenant
    public static ?Tenant $currentTenant = null;

    protected $fillable = [
        'name',
        'slug',
        'tax_id',
        'subscription_tier_id',
        'status',
        'settings',
        'stripe_id',
        'pm_type',
        'pm_last_four',
        'trial_ends_at',
        'subscription_ends_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    public function subscriptionTier(): BelongsTo
    {
        return $this->belongsTo(SubscriptionTier::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'tenant_user')
            ->withPivot(['role', 'permissions', 'is_active', 'joined_at'])
            ->withTimestamps();
    }

    public function invitations(): HasMany
    {
        return $this->hasMany(TeamInvitation::class);
    }
    
    /**
     * Check if the tenant is on a trial period.
     */
    public function onTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Set the globally identified tenant.
     */
    public static function setGlobalTenant(?Tenant $tenant): void
    {
        static::$currentTenant = $tenant;
    }

    /**
     * Get the globally identified tenant.
     */
    public static function getGlobalTenant(): ?Tenant
    {
        return static::$currentTenant;
    }
}