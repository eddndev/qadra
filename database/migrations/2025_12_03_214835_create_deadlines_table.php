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
        Schema::create('deadlines', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->ulid('tenant_id');
            $table->ulid('case_id');
            $table->ulid('hearing_id')->nullable();
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->dateTime('expires_at');
            $table->boolean('is_fatal')->default(false);
            $table->json('reminder_config')->nullable(); // {"days_before": [7, 3, 1, 0]}
            $table->string('status', 50); // pendiente, cumplido, vencido
            $table->timestamp('completed_at')->nullable();
            $table->ulid('completed_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('case_id')->references('id')->on('legal_cases')->onDelete('cascade');
            $table->foreign('hearing_id')->references('id')->on('hearings')->onDelete('cascade');
            $table->foreign('completed_by')->references('id')->on('users')->onDelete('set null');

            $table->index(['tenant_id', 'id']);
            $table->index(['tenant_id', 'case_id', 'expires_at']);
            $table->index(['tenant_id', 'status', 'expires_at']);
            $table->index('is_fatal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deadlines');
    }
};