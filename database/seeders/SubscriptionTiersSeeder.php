<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionTiersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscription_tiers')->insert([
            [
                'name' => 'Starter',
                'slug' => 'starter',
                'description' => 'Para despachos pequeños que inician su transformación digital.',
                'price_monthly' => 9900, // $99.00
                'price_yearly' => 99000, // $990.00
                'max_users' => 3,
                'max_storage_gb' => 10,
                'max_active_cases' => 20,
                'features' => json_encode([
                    'client_portal' => false,
                    'advanced_reports' => false,
                    'audit_logs' => false,
                    'api_access' => false,
                ]),
                'is_active' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Para firmas en crecimiento que requieren gestión avanzada y auditoría.',
                'price_monthly' => 24900, // $249.00
                'price_yearly' => 249000, // $2490.00
                'max_users' => 10,
                'max_storage_gb' => 50,
                'max_active_cases' => 100,
                'features' => json_encode([
                    'client_portal' => true,
                    'advanced_reports' => true,
                    'audit_logs' => true,
                    'api_access' => false,
                ]),
                'is_active' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}