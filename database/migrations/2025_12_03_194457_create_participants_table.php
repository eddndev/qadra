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
        Schema::create('participants', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_id')->constrained('tenants')->cascadeOnDelete();
            
            $table->string('type', 50); // fisica, moral, autoridad
            $table->string('name', 255);
            
            $table->string('rfc', 13)->nullable();
            $table->string('curp', 18)->nullable();
            
            $table->string('gender', 20)->nullable();
            $table->date('date_of_birth')->nullable();
            
            $table->json('contact_details')->nullable(); // email, phone, address encrypted via cast
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            $table->index(['tenant_id', 'name']);
            $table->index(['tenant_id', 'rfc']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('participants');
    }
};