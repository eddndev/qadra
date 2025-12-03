<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('legal_cases', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            
            $table->string('internal_folio', 100);
            $table->string('nuc', 100)->nullable();
            $table->string('judicial_file_number', 100)->nullable();
            $table->string('case_alias', 255)->nullable();
            
            // Detalles del Delito
            $table->string('crime_type', 255);
            $table->string('crime_classification', 50)->nullable(); // doloso, culposo
            $table->string('crime_severity', 50)->nullable(); // grave, no_grave
            
            // Estado Procesal
            $table->string('stage', 50); // inv_inicial, inv_complementaria, etc.
            $table->string('status', 50); // activo, suspendido, cerrado
            
            // Fechas Clave
            $table->date('start_date');
            $table->date('close_date')->nullable();
            
            // Asignaciones (Users)
            $table->foreignUlid('lead_lawyer_id')->constrained('users')->restrictOnDelete();
            $table->foreignUlid('assigned_to_id')->nullable()->constrained('users')->nullOnDelete();
            
            // Autoridades (Texto libre por ahora, o relaciones futuras)
            $table->string('court_name', 255)->nullable();
            $table->string('prosecutor_name', 255)->nullable();
            $table->string('judge_name', 255)->nullable();
            
            // Fechas de Hitos
            $table->dateTime('initial_hearing_date')->nullable();
            $table->dateTime('arraignment_date')->nullable();
            $table->dateTime('trial_date')->nullable();
            
            $table->longText('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Índices compuestos para performance Multi-Tenant
            $table->index(['tenant_id', 'internal_folio']);
            $table->index(['tenant_id', 'nuc']);
            $table->index(['tenant_id', 'stage']);
            $table->index(['tenant_id', 'status']);
            $table->index(['tenant_id', 'lead_lawyer_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_cases');
    }
};