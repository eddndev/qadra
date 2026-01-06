<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SubscriptionTiersSeeder::class,
            PermissionsAndRolesSeeder::class,
            CrimeTypesSeeder::class,
            PrecautionaryMeasureTypesSeeder::class,
            DeadlineTypesSeeder::class,
            HearingTypesSeeder::class,
            SuperAdminSeeder::class,
            LandingPageSeeder::class,
            DemoDataSeeder::class,
            DemoCasesSeeder::class,
        ]);

        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}