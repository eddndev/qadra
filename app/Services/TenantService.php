<?php

namespace App\Services;

use App\Models\Tenant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;

class TenantService
{
    /**
     * Sync permissions for a tenant's roles based on their subscription tier features.
     * Currently only targets the 'owner' role.
     */
    public function syncPermissions(Tenant $tenant): void
    {
        Log::info("Syncing permissions for Tenant: {$tenant->name} ({$tenant->id})");

        if (!$tenant->subscriptionTier) {
            Log::warning("Tenant {$tenant->id} has no subscription tier. Skipping permission sync.");
            return;
        }

        $tier = $tenant->subscriptionTier;
        $features = $tier->features ?? [];
        
        // Find the 'owner' role for this tenant
        // Scoped to tenant_id
        $ownerRole = Role::where('name', 'owner')
            ->where('tenant_id', $tenant->id)
            ->first();

        if (!$ownerRole) {
            Log::error("Owner role not found for tenant {$tenant->id}.");
            return;
        }

        // Define conditional permissions logic
        $permissionsToAdd = [];
        $permissionsToRemove = [];

        // Advanced Reports Logic
        if (!empty($features['advanced_reports']) && $features['advanced_reports'] === true) {
            $permissionsToAdd[] = 'reports.advanced';
            $permissionsToAdd[] = 'reports.export';
        } else {
            $permissionsToRemove[] = 'reports.advanced';
            $permissionsToRemove[] = 'reports.export';
        }

        // Apply Additions
        foreach ($permissionsToAdd as $permName) {
            // Ensure permission exists in DB
            $permission = Permission::firstOrCreate(['name' => $permName, 'guard_name' => 'web']);
            
            if (!$ownerRole->hasPermissionTo($permName)) {
                $ownerRole->givePermissionTo($permission);
                Log::info("Tenant {$tenant->id}: Granted {$permName} to owner.");
            }
        }

        // Apply Removals
        foreach ($permissionsToRemove as $permName) {
            if ($ownerRole->hasPermissionTo($permName)) {
                $ownerRole->revokePermissionTo($permName);
                Log::info("Tenant {$tenant->id}: Revoked {$permName} from owner.");
            }
        }
    }
}
