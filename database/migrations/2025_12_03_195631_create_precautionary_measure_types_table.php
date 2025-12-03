<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('precautionary_measure_types', function (Blueprint $table) {
            $table->id();
            $table->string('fraction', 10)->nullable(); // I, II, III...
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('legal_basis', 255)->default('Art. 155 CNPP');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('precautionary_measure_types');
    }
};