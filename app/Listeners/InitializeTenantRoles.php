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

            // Assign default permissions based on the Subscription Tier features
            if ($roleName === 'owner') {
                $tier = $tenant->subscriptionTier;
                $features = $tier->features ?? [];

                // Base permissions (always granted to owner)
                $ownerPermissions = [
                    'cases.view_all',
                    'cases.view_assigned',
                    'cases.create',
                    'cases.edit',
                    'cases.delete',
                    'cases.close',
                    'cases.assign',
                    'participants.view',
                    'participants.create',
                    'participants.edit',
                    'participants.delete',
                    'documents.view',
                    'documents.upload',
                    'documents.delete',
                    'documents.share_with_client',
                    'hearings.view',
                    'hearings.create',
                    'hearings.edit',
                    'hearings.delete',
                    'hearings.record_result',
                    'activities.view',
                    'activities.create',
                    'activities.edit',
                    'activities.delete',
                    'evidence.view',
                    'evidence.create',
                    'evidence.edit',
                    'evidence.custody_manage',
                    'deadlines.view',
                    'deadlines.create',
                    'deadlines.edit',
                    'deadlines.complete',
                    'measures.view',
                    'measures.create',
                    'measures.edit',
                    'solutions.view',
                    'solutions.create',
                    'solutions.edit',
                    'team.view',
                    'team.invite',
                    'team.edit_roles',
                    'team.remove',
                    'subscription.view',
                    'subscription.manage',
                    'settings.view',
                    'settings.edit',
                ];

                // Conditional Permissions based on Features JSON
                if (!empty($features['advanced_reports'])) {
                    $ownerPermissions[] = 'reports.advanced';
                    $ownerPermissions[] = 'reports.export';
                }

                foreach ($ownerPermissions as $permName) {
                    $permission = Permission::where('name', $permName)->first();
                    if ($permission) {
                        $role->givePermissionTo($permission);
                    }
                }
            }
        }
    }
}