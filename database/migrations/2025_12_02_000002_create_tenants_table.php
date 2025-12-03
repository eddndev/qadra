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
        Schema::create('tenants', function (Blueprint $table) {
            $table->char('id', 26)->primary(); // ULID
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('tax_id', 50)->nullable();
            
            $table->foreignId('subscription_tier_id')->constrained('subscription_tiers');
            
            $table->string('status', 20)->index(); // active, suspended, trial, cancelled
            $table->json('settings')->nullable();
            
            // Stripe Billing
            $table->string('stripe_id')->nullable()->index();
            $table->string('pm_type', 50)->nullable();
            $table->string('pm_last_four', 4)->nullable();
            $table->timestamp('trial_ends_at')->nullable();
            $table->timestamp('subscription_ends_at')->nullable();
            
            // Cache Counters (Performance)
            $table->integer('current_users_count')->default(0);
            $table->integer('current_active_cases_count')->default(0);
            $table->bigInteger('current_storage_usage_bytes')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
