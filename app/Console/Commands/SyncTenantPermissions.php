<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SyncTenantPermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:sync-permissions {tenant_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync permissions for tenant roles based on their subscription tier';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tenantId = $this->argument('tenant_id');

        $query = Tenant::with('subscriptionTier');
        if ($tenantId) {
            $query->where('id', $tenantId);
        }

        $tenants = $query->get();

        foreach ($tenants as $tenant) {
            $this->info("Syncing permissions for Tenant: {$tenant->name} ({$tenant->id})");

            if (!$tenant->subscriptionTier) {
                $this->warn("  - No subscription tier found. Skipping.");
                continue;
            }

            $tier = $tenant->subscriptionTier;
            $features = $tier->features ?? [];
            
            // Find the 'owner' role for this tenant
            // Note: Roles are scoped by tenant_id in our setup if using team logic, 
            // OR checks guard_name 'web'. Assuming 'owner' role is created per tenant via InitializeTenantRoles logic.
            // Based on InitializeTenantRoles.php: Role::firstOrCreate(['name' => 'owner', 'tenant_id' => $tenant->id])
            
            $ownerRole = Role::where('name', 'owner')
                ->where('tenant_id', $tenant->id)
                ->first();

            if (!$ownerRole) {
                $this->error("  - Owner role not found for this tenant.");
                continue;
            }

            // Sync Permissions via Service
            $tenantService = new \App\Services\TenantService();
            $tenantService->syncPermissions($tenant);
            
            $this->info("    - Permissions synced.");
        }

        $this->info('Tenant permission sync completed.');
    }
}
