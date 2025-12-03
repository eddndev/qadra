<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('crime_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->unique();
            $table->string('classification', 50)->default('doloso'); // doloso, culposo
            $table->string('severity', 50)->default('grave'); // grave, no_grave
            $table->string('legal_basis', 255)->nullable(); // Art. 19 Const, CPF, etc.
            $table->boolean('is_federal')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('crime_types');
    }
};