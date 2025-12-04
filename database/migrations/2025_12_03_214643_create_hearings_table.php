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
        Schema::create('hearings', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id');
            $table->ulid('case_id');
            $table->string('type', 100);
            $table->dateTime('scheduled_at');
            $table->integer('duration_minutes')->nullable();
            $table->string('courtroom', 255)->nullable();
            $table->string('virtual_link', 500)->nullable();
            $table->ulid('judge_participant_id')->nullable();
            $table->string('status', 50); // programada, celebrada, cancelada, reprogramada
            $table->longText('result_summary')->nullable();
            $table->dateTime('next_hearing_date')->nullable();
            $table->json('attended_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('case_id')->references('id')->on('legal_cases')->onDelete('cascade');
            $table->foreign('judge_participant_id')->references('id')->on('participants')->onDelete('set null');

            $table->index(['tenant_id', 'id']);
            $table->index(['tenant_id', 'case_id', 'scheduled_at']);
            $table->index(['tenant_id', 'scheduled_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hearings');
    }
};