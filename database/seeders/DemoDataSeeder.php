<?php

namespace Database\Seeders;

use App\Events\TenantCreated;
use App\Models\Activity;
use App\Models\Evidence;
use App\Models\Hearing;
use App\Models\LegalCase;
use App\Models\Participant;
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
                'start_date' => now()->subMonths(rand(2, 6))->subDays(rand(1, 28)),
                'notes' => 'El cliente mantiene que actuó en defensa propia. Se requiere peritaje de balística urgente antes de la próxima audiencia.',
                'created_at' => now()->subMonths(rand(2, 6))->subDays(rand(1, 28)),
            ]
        );

        // --- ACTUACIONES Y ACTIVIDADES (GARCIA) ---
        Activity::create([
            'tenant_id' => $tenant1->id,
            'case_id' => $case1->id,
            'performed_by' => $user1->id,
            'type' => 'Llamada Telefónica',
            'title' => 'Llamada con el Cliente',
            'description' => 'Se explicó la estrategia para la audiencia de vinculación. El cliente está tranquilo.',
            'performed_at' => now()->subDays(2)->setTime(16, 30),
            'duration_minutes' => 15,
        ]);

        Activity::create([
            'tenant_id' => $tenant1->id,
            'case_id' => $case1->id,
            'performed_by' => $user1->id,
            'type' => 'Visita a Juzgado',
            'title' => 'Revisión de Expediente',
            'description' => 'Se verificó que el MP haya integrado el informe policial homologado. Faltan las fotos de la escena.',
            'performed_at' => now()->subDays(5)->setTime(10, 0),
            'duration_minutes' => 45,
        ]);

        // --- PARTICIPANTES (GARCIA) ---
        // 1. Imputado
        $imputado = Participant::create([
            'tenant_id' => $tenant1->id,
            'type' => 'Persona Física',
            'name' => 'Juan Pérez Gómez',
            'gender' => 'Masculino',
            'notes' => 'Primer ingreso al sistema penal.',
        ]);
        $case1->participants()->attach($imputado->id, [
            'role' => 'imputado',
            'alias' => 'El Juancho',
            'is_detained' => true,
            'defense_attorney_name' => 'Lic. Roberto García',
        ]);

        // 2. Víctima
        $victima = Participant::create([
            'tenant_id' => $tenant1->id,
            'type' => 'Persona Física',
            'name' => 'María López Torres',
            'gender' => 'Femenino',
        ]);
        $case1->participants()->attach($victima->id, [
            'role' => 'victima',
            'notes' => 'Solicita reparación del daño por 500k.',
        ]);

        // 3. Juez
        $juez = Participant::create([
            'tenant_id' => $tenant1->id,
            'type' => 'Funcionario Público',
            'name' => 'Lic. Carlos Ruiz',
            'gender' => 'Masculino',
        ]);
        $case1->participants()->attach($juez->id, [
            'role' => 'juez',
            'notes' => 'Juez de Control del Quinto Distrito.',
        ]);

        // 4. Fiscal
        $fiscal = Participant::create([
            'tenant_id' => $tenant1->id,
            'type' => 'Funcionario Público',
            'name' => 'Lic. Ana Torres',
            'gender' => 'Femenino',
        ]);
        $case1->participants()->attach($fiscal->id, [
            'role' => 'fiscal',
            'notes' => 'Ministerio Público adscrito a la Unidad de Investigación.',
        ]);

        // Update simple field for compatibility
        $case1->update(['prosecutor_name' => 'Lic. Ana Torres']);

        // --- EVIDENCIA (GARCIA) ---
        Evidence::create([
            'tenant_id' => $tenant1->id,
            'case_id' => $case1->id,
            'chain_of_custody_folio' => 'CC-2024-001',
            'description' => 'Cuchillo de cocina con mango de madera (Presunta arma)',
            'type' => 'Objeto',
            'status' => 'en_fiscalia',
            'current_location' => 'Bodega de Evidencias Fiscalía',
            'collected_at' => now()->subMonths(2)->subDays(1),
            'collected_by' => 'Perito Juan N.',
            'notes' => 'Recuperado en la escena del crimen.',
        ]);

        Evidence::create([
            'tenant_id' => $tenant1->id,
            'case_id' => $case1->id,
            'chain_of_custody_folio' => 'CC-2024-002',
            'description' => 'Ticket de compra de tienda "El Sol"',
            'type' => 'Documento',
            'status' => 'en_custodia',
            'current_location' => 'Caja fuerte del despacho',
            'collected_at' => now()->subMonths(1),
            'collected_by' => 'Lic. Roberto García',
            'notes' => 'Prueba de coartada del imputado.',
        ]);

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
                'start_date' => now()->subMonths(rand(1, 5))->subDays(rand(1, 28)),
                'created_at' => now()->subMonths(rand(1, 5))->subDays(rand(1, 28)),
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
