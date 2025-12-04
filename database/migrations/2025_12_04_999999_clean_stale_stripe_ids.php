<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Limpiar los IDs de Stripe antiguos para evitar conflictos con las nuevas llaves
        DB::table('tenants')->update([
            'stripe_id' => null,
            'pm_type' => null,
            'pm_last_four' => null,
            'trial_ends_at' => null, // Opcional: Reiniciar trial si quieres
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No se puede revertir la pérdida de datos de IDs
    }
};
