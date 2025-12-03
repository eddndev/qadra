<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;

trait TenantScoped
{
    /**
     * The "booted" method of the model.
     */
    protected static function bootTenantScoped(): void
    {
        // Auto-assign tenant_id on creation
        static::creating(function ($model) {
            if (!$model->tenant_id && auth()->check() && session()->has('current_tenant_id')) {
                $model->tenant_id = session()->get('current_tenant_id');
            }
        });

        // Apply global scope
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (auth()->check() && session()->has('current_tenant_id')) {
                $builder->where('tenant_id', session()->get('current_tenant_id'));
            }
        });
    }

    /**
     * Get the tenant that owns the model.
     */
    public function tenant()
    {
        return $this->belongsTo(\App\Models\Tenant::class);
    }
}
