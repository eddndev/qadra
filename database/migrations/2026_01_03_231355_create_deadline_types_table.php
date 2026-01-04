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
        Schema::create('deadline_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('default_days')->nullable(); // Null means varies or implies hours
            $table->boolean('business_days')->default(true); // True = Hábiles, False = Naturales
            $table->string('legal_basis')->nullable(); // e.g., "Art. 321 CNPP"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deadline_types');
    }
};
