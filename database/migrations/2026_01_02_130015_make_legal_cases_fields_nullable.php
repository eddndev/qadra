<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('legal_cases', function (Blueprint $table) {
            $table->string('crime_type', 255)->nullable()->change();
            $table->string('stage', 50)->nullable()->change();
            $table->date('start_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_cases', function (Blueprint $table) {
            // Reverting requires valid data or it might fail if nulls exist. 
            // We assume for rollback we just enforcing not null again.
            $table->string('crime_type', 255)->nullable(false)->change();
            $table->string('stage', 50)->nullable(false)->change();
            $table->date('start_date')->nullable(false)->change();
        });
    }
};
