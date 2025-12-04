<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('media', function (Blueprint $table) {
            // Change model_id to string to support ULIDs/UUIDs
            // We drop the index first to avoid issues, then modify, then re-add index
            // Note: Spatie's migration creates a compound index on (model_type, model_id)
            
            // Drop existing index if it exists (name might vary, usually media_model_type_model_id_index)
            try {
                $table->dropIndex(['model_type', 'model_id']);
            } catch (\Exception $e) {
                // Index might be named differently or not exist, ignore
            }

            // Modify column
            $table->string('model_id', 36)->change();
            
            // Re-add index
            $table->index(['model_type', 'model_id']);
        });
    }

    public function down(): void
    {
        // Reverting is risky if we have data, but technically we'd go back to bigInt
        Schema::table('media', function (Blueprint $table) {
             $table->dropIndex(['model_type', 'model_id']);
             $table->unsignedBigInteger('model_id')->change();
             $table->index(['model_type', 'model_id']);
        });
    }
};
