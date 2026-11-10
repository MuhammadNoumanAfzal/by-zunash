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
        Schema::create('abandoned_carts', function (Blueprint $table) {
            $table->id();
            $table->string('cart_token', 100)->nullable()->index();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone', 50)->nullable()->index();
            $table->string('customer_email')->nullable();
            $table->string('city', 100)->nullable();
            $table->text('shipping_address')->nullable();
            $table->json('items')->nullable();
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);
            $table->string('status', 20)->default('abandoned'); // 'abandoned', 'contacted', 'recovered'
            $table->string('recovery_discount_code', 50)->default('ATELIER5');
            $table->timestamp('contacted_at')->nullable();
            $table->timestamp('recovered_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('abandoned_carts');
    }
};
