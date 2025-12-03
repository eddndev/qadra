<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsAndRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        // app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Define permissions list
        $permissions = [
            // Cases
            'cases.view_all',
            'cases.view_assigned',
            'cases.create',
            'cases.edit',
            'cases.delete',
            'cases.close',
            'cases.assign',
            
            // Participants
            'participants.view',
            'participants.create',
            'participants.edit',
            'participants.delete',
            
            // Documents
            'documents.view',
            'documents.upload',
            'documents.delete',
            'documents.share_with_client',
            
            // Hearings
            'hearings.view',
            'hearings.create',
            'hearings.edit',
            'hearings.delete',
            'hearings.record_result',
            
            // Activities
            'activities.view',
            'activities.create',
            'activities.edit',
            'activities.delete',
            
            // Evidence
            'evidence.view',
            'evidence.create',
            'evidence.edit',
            'evidence.custody_manage',
            
            // Deadlines
            'deadlines.view',
            'deadlines.create',
            'deadlines.edit',
            'deadlines.complete',
            
            // Measures (CNPP)
            'measures.view',
            'measures.create',
            'measures.edit',
            
            // Solutions (CNPP)
            'solutions.view',
            'solutions.create',
            'solutions.edit',
            
            // Reports
            'reports.basic',
            'reports.advanced',
            'reports.export',
            
            // Team Management
            'team.view',
            'team.invite',
            'team.edit_roles',
            'team.remove',
            
            // Subscription & Settings
            'subscription.view',
            'subscription.manage',
            'settings.view',
            'settings.edit',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // We do NOT create Roles here because Roles are tenant-specific in our multi-tenant setup.
        // Roles like 'owner', 'litigante' will be created dynamically when a new Tenant is registered
        // (inside the RegisterTenant logic or TenantCreated observer).
    }
}