<?php

namespace App\Listeners;

use App\Events\TenantCreated;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class InitializeTenantRoles
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TenantCreated $event): void
    {
        $tenant = $event->tenant;
        $guardName = 'web';

        // Define base roles
        $roles = [
            'owner',
            'litigante',
            'asociado',
            'paralegal',
            'administrativo',
            'cliente'
        ];

        // Create roles for this specific tenant
        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => $guardName,
                'tenant_id' => $tenant->id, // Scoped to tenant (using team_foreign_key logic)
            ]);

            // Optional: Assign default permissions to roles here
            // For example, give 'owner' all permissions
            if ($roleName === 'owner') {
                // We assign all available permissions to the owner role
                // Note: Permissions are global (team_id=null) in our setup, but role assignment handles the scope.
                // Or if permissions were tenant-specific, we would create them too.
                // Here we assume permissions are global constants.
                $role->givePermissionTo(Permission::all());
            }
        }
    }
}