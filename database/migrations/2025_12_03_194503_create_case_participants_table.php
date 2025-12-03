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
        Schema::create('case_participants', function (Blueprint $table) {
            $table->id(); // Pivot usa BigInt
            
            $table->foreignUlid('case_id')->constrained('legal_cases')->cascadeOnDelete();
            $table->foreignUlid('participant_id')->constrained('participants')->cascadeOnDelete();
            
            $table->string('role', 50); // imputado, victima, juez, etc.
            $table->string('alias', 255)->nullable();
            
            $table->boolean('is_detained')->default(false);
            $table->string('defense_attorney_name', 255)->nullable();
            $table->text('notes')->nullable();
            
            $table->timestamps();

            $table->unique(['case_id', 'participant_id', 'role']);
            $table->index('case_id');
            $table->index('participant_id');
            $table->index('role');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('case_participants');
    }
};