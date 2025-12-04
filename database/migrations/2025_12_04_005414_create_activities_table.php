<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id')->index();
            $table->ulid('case_id')->index();
            $table->ulid('performed_by')->index(); // Usuario que realizó la acción
            
            $table->string('type', 50); // Llamada, Email, Visita, Escrito, etc.
            $table->string('title', 255);
            $table->text('description')->nullable();
            
            $table->datetime('performed_at');
            $table->integer('duration_minutes')->nullable(); // Para facturación futura
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('case_id')->references('id')->on('legal_cases')->onDelete('cascade');
            $table->foreign('performed_by')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};