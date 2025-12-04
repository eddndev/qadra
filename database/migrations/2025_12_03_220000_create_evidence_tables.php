<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidence', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignUlid('case_id')->constrained('legal_cases')->onDelete('cascade');
            
            $table->string('chain_of_custody_folio', 100);
            $table->string('description', 500);
            $table->string('type', 100); // arma, documento, dispositivo, etc.
            $table->string('current_location', 255)->nullable();
            $table->string('status', 50); // en_custodia, en_fiscalia, etc.
            
            $table->dateTime('collected_at')->nullable();
            $table->string('collected_by')->nullable(); // Nombre de autoridad
            $table->text('notes')->nullable();
            
            $table->timestamps();
            $table->softDeletes();
            
            // Indices
            $table->index(['tenant_id', 'case_id']);
            $table->index(['tenant_id', 'chain_of_custody_folio']);
            $table->index(['tenant_id', 'status']);
        });

        Schema::create('chain_of_custody_entries', function (Blueprint $table) {
            $table->ulid('id')->primary();
            $table->foreignUlid('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignUlid('evidence_id')->constrained('evidence')->onDelete('cascade');
            
            $table->dateTime('movement_at');
            $table->string('given_by');
            $table->string('given_by_badge')->nullable();
            $table->string('received_by');
            $table->string('received_by_badge')->nullable();
            $table->string('reason');
            $table->string('location')->nullable();
            $table->string('condition')->nullable();
            
            $table->foreignUlid('registered_by')->constrained('users')->onDelete('restrict');
            
            $table->timestamp('created_at')->useCurrent();
            // No updated_at for immutability
            
            $table->index(['tenant_id', 'evidence_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chain_of_custody_entries');
        Schema::dropIfExists('evidence');
    }
};
