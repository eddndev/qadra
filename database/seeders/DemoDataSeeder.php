<?php

namespace Database\Seeders;

use App\Events\TenantCreated;
use App\Models\Hearing;
use App\Models\LegalCase;
use App\Models\SubscriptionTier;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proTier = SubscriptionTier::where('slug', 'professional')->first();

        // --- BUFETE 1: García & Asociados ---
        $user1 = User::updateOrCreate(
            ['email' => 'garcia@demo.com'],
            [
                'name' => 'Lic. Roberto García',
                'password' => Hash::make('demo1234'),
                'email_verified_at' => now(),
            ]
        );

        $tenant1 = Tenant::updateOrCreate(
            ['slug' => 'garcia-asociados'],
            [
                'name' => 'García & Asociados',
                'status' => 'active',
                'trial_ends_at' => now()->addDays(14),
                'subscription_tier_id' => $proTier->id,
            ]
        );

        if (!$tenant1->users()->where('users.id', $user1->id)->exists()) {
            $tenant1->users()->attach($user1->id, ['role' => 'owner', 'joined_at' => now()]);
            event(new TenantCreated($tenant1));
        }

        $case1 = LegalCase::updateOrCreate(
            ['tenant_id' => $tenant1->id, 'internal_folio' => 'EXP-2024-001'],
            [
                'case_alias' => 'Homicidio Culposo - Juan Pérez',
                'stage' => 'investigacion_complementaria',
                'status' => 'activo',
                'lead_lawyer_id' => $user1->id,
                'start_date' => now()->subMonths(2),
            ]
        );

        Hearing::updateOrCreate(
            ['case_id' => $case1->id, 'type' => 'Audiencia de Vinculación'],
            [
                'tenant_id' => $tenant1->id,
                'scheduled_at' => now()->addDays(5)->setTime(10, 0),
                'status' => 'programada',
                'duration_minutes' => 60,
                'courtroom' => 'Sala 4 Penal',
            ]
        );

        // --- BUFETE 2: Jurídico Norte ---
        $user2 = User::updateOrCreate(
            ['email' => 'juridico@norte.com'],
            [
                'name' => 'Dra. Elena Martínez',
                'password' => Hash::make('demo1234'),
                'email_verified_at' => now(),
            ]
        );

        $tenant2 = Tenant::updateOrCreate(
            ['slug' => 'juridico-norte'],
            [
                'name' => 'Bufete Jurídico Norte',
                'status' => 'active',
                'trial_ends_at' => now()->addDays(14),
                'subscription_tier_id' => $proTier->id,
            ]
        );

        if (!$tenant2->users()->where('users.id', $user2->id)->exists()) {
            $tenant2->users()->attach($user2->id, ['role' => 'owner', 'joined_at' => now()]);
            event(new TenantCreated($tenant2));
        }

        $case2 = LegalCase::updateOrCreate(
            ['tenant_id' => $tenant2->id, 'internal_folio' => 'EXP-2024-015'],
            [
                'case_alias' => 'Robo con Violencia - Caso Centro',
                'stage' => 'juicio_oral',
                'status' => 'activo',
                'lead_lawyer_id' => $user2->id,
                'start_date' => now()->subMonths(1),
            ]
        );

        Hearing::updateOrCreate(
            ['case_id' => $case2->id, 'type' => 'Apertura de Juicio'],
            [
                'tenant_id' => $tenant2->id,
                'scheduled_at' => now()->addDays(10)->setTime(9, 0),
                'status' => 'programada',
                'duration_minutes' => 120,
                'courtroom' => 'Sala 1 Oralidad',
            ]
        );
    }
}
