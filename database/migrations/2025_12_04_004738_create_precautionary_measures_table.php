<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('precautionary_measures', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id')->index();
            $table->ulid('case_id')->index();
            $table->ulid('participant_id')->index(); // Must be 'imputado' role, validation in logic
            $table->unsignedBigInteger('measure_type_id');
            
            $table->text('description'); // Specifics: amount, address, frequency
            $table->date('imposed_at');
            $table->string('judge_name')->nullable();
            
            $table->date('review_date')->nullable(); // Mandatory for Prision Preventiva
            $table->date('expires_at')->nullable();
            
            $table->string('status', 50)->default('vigente'); // vigente, revocada, cumplida
            $table->text('revoked_reason')->nullable();
            $table->date('revoked_at')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign Keys
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('case_id')->references('id')->on('legal_cases')->onDelete('cascade');
            $table->foreign('participant_id')->references('id')->on('participants')->onDelete('cascade');
            $table->foreign('measure_type_id')->references('id')->on('precautionary_measure_types');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('precautionary_measures');
    }
};