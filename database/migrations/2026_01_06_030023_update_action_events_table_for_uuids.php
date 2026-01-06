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
        Schema::table('action_events', function (Blueprint $table) {
            $table->string('user_id', 36)->change();
            $table->string('actionable_id', 36)->change();
            $table->string('target_id', 36)->change();
            $table->string('model_id', 36)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('action_events', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->change();
            $table->unsignedBigInteger('actionable_id')->change();
            $table->unsignedBigInteger('target_id')->change();
            $table->unsignedBigInteger('model_id')->nullable()->change();
        });
    }
};
