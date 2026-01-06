<?php

namespace Database\Seeders;

use App\Models\Deadline;
use App\Models\Hearing;
use App\Models\LegalCase;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DemoCasesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Target specifically the Garcia tenant
        $tenant = Tenant::where('slug', 'garcia-asociados')->first();
        if (!$tenant) {
            $this->command->error('Tenant garcia-asociados not found. Run DemoDataSeeder first.');
            return;
        }

        $owner = User::where('email', 'garcia@demo.com')->first();

        // Date for testing alerts: January 6, 2026
        // We set different times to test ordering
        $alertDate = Carbon::create(2026, 1, 6);

        // --- CASO 1: Fraude Corporativo (Audiencia Hoy) ---
        $case1 = LegalCase::create([
            'tenant_id' => $tenant->id,
            'internal_folio' => 'EXP-2024-050',
            'case_alias' => 'Fraude Constructora XYZ',
            'crime_type' => 'Fraude',
            'stage' => 'investigacion_inicial',
            'status' => 'activo',
            'lead_lawyer_id' => $owner->id,
            'start_date' => now()->subMonths(3),
            'notes' => 'Caso de alto perfil. Revisar notificaciones hoy.',
        ]);

        Hearing::create([
            'tenant_id' => $tenant->id,
            'case_id' => $case1->id,
            'type' => 'Audiencia Inicial',
            'scheduled_at' => $alertDate->copy()->setTime(12, 00), // 12:00 PM Today
            'duration_minutes' => 90,
            'status' => 'programada',
            'courtroom' => 'Sala 2 Oralidad',
            'notes' => 'Audiencia crítica para determinar vinculación.',
        ]);

        // --- CASO 2: Robo Simple (Plazo Fatal Hoy) ---
        $case2 = LegalCase::create([
            'tenant_id' => $tenant->id,
            'internal_folio' => 'EXP-2024-051',
            'case_alias' => 'Robo Tienda Conveniencia',
            'crime_type' => 'Robo',
            'stage' => 'investigacion_complementaria',
            'status' => 'activo',
            'lead_lawyer_id' => $owner->id,
            'start_date' => now()->subMonths(1),
        ]);

        Deadline::create([
            'tenant_id' => $tenant->id,
            'case_id' => $case2->id,
            'title' => 'Cierre de Investigación',
            'description' => 'Vence plazo para presentar acusación o solicitar sobreseimiento.',
            'expires_at' => $alertDate->copy()->setTime(23, 59), // End of Today
            'is_fatal' => true,
            'status' => 'pendiente',
            'reminder_config' => ['email' => true, 'push' => true],
        ]);

        // --- CASO 3: Despojo (Audiencia Mañana - Próxima) ---
        $case3 = LegalCase::create([
            'tenant_id' => $tenant->id,
            'internal_folio' => 'EXP-2024-052',
            'case_alias' => 'Despojo Terreno Ejidal',
            'crime_type' => 'Despojo',
            'stage' => 'intermedia',
            'status' => 'activo',
            'lead_lawyer_id' => $owner->id,
            'start_date' => now()->subMonths(5),
        ]);

        Hearing::create([
            'tenant_id' => $tenant->id,
            'case_id' => $case3->id,
            'type' => 'Audiencia Intermedia',
            'scheduled_at' => $alertDate->copy()->addDay()->setTime(9, 30), // Tomorrow 9:30 AM
            'duration_minutes' => 60,
            'status' => 'programada',
            'courtroom' => 'Juzgado 3ro Mixto',
        ]);
    }
}
