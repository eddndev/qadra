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
        Schema::create('procedural_stage_histories', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            $table->foreignUlid('case_id')->constrained('legal_cases')->cascadeOnDelete(); // Nota: legal_cases
            
            $table->string('previous_stage', 50)->nullable();
            $table->string('new_stage', 50);
            
            $table->string('previous_status', 50)->nullable();
            $table->string('new_status', 50);
            
            $table->text('reason')->nullable();
            
            $table->foreignUlid('changed_by')->constrained('users')->restrictOnDelete();
            
            $table->timestamp('created_at')->useCurrent();
            // No updated_at or deleted_at (Immutable)

            $table->index(['tenant_id', 'case_id', 'created_at'], 'idx_stage_history_composite');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedural_stage_histories');
    }
};