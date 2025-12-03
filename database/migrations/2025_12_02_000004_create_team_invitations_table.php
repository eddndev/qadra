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
        Schema::create('team_invitations', function (Blueprint $table) {
            $table->char('id', 26)->primary(); // ULID
            $table->char('tenant_id', 26);
            
            $table->string('email');
            $table->string('role', 50);
            $table->string('token')->unique();
            
            $table->char('invited_by', 26);
            $table->timestamp('expires_at')->index();
            $table->timestamp('accepted_at')->nullable();
            
            $table->timestamps();

            // Relationships
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('invited_by')->references('id')->on('users')->onDelete('cascade');

            $table->index(['tenant_id', 'email']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_invitations');
    }
};
