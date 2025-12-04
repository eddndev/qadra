<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alternative_solutions', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id')->index();
            $table->ulid('case_id')->index();
            
            $table->string('type', 50); // Acuerdo Reparatorio, Suspension Condicional, Procedimiento Abreviado
            $table->date('proposal_date');
            
            $table->date('approved_at')->nullable(); // Fecha de aprobación judicial
            $table->string('judge_name')->nullable();
            
            $table->text('conditions'); // Detalles del acuerdo
            $table->date('compliance_deadline')->nullable(); // Fecha límite de cumplimiento
            
            $table->string('status', 30)->default('propuesta'); // propuesta, aprobada, cumplida, revocada
            
            $table->text('revoked_reason')->nullable();
            $table->date('revoked_at')->nullable();
            $table->date('completed_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('case_id')->references('id')->on('legal_cases')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alternative_solutions');
    }
};