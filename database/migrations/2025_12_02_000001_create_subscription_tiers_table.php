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
        Schema::create('subscription_tiers', function (Blueprint $table) {
            $table->id(); // Standard BigInt for catalog
            $table->string('name', 50);
            $table->string('slug', 50)->unique();
            $table->text('description')->nullable();
            
            // Pricing (in cents)
            $table->integer('price_monthly');
            $table->integer('price_yearly');
            
            // Stripe mappings
            $table->string('stripe_product_id')->nullable();
            $table->string('stripe_price_monthly_id')->nullable();
            $table->string('stripe_price_yearly_id')->nullable();
            
            // Limits & Quotas
            $table->integer('max_users');
            $table->integer('max_storage_gb');
            $table->integer('max_active_cases');
            
            // Feature Flags
            $table->json('features')->nullable();
            
            $table->boolean('is_active')->default(true)->index();
            $table->integer('sort_order')->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscription_tiers');
    }
};
