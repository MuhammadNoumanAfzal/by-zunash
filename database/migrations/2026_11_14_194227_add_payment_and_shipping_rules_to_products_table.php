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
        Schema::table('products', function (Blueprint $table) {
            if (!Schema::hasColumn('products', 'allowed_payment_methods')) {
                $table->string('allowed_payment_methods', 30)->default('all')->after('availability');
            }
            if (!Schema::hasColumn('products', 'custom_shipping_charge')) {
                $table->decimal('custom_shipping_charge', 10, 2)->nullable()->after('allowed_payment_methods');
            }
            if (!Schema::hasColumn('products', 'weight_kg')) {
                $table->decimal('weight_kg', 8, 2)->default(0.50)->after('custom_shipping_charge');
            }
            if (!Schema::hasColumn('products', 'is_free_shipping')) {
                $table->boolean('is_free_shipping')->default(false)->after('weight_kg');
            }
            if (!Schema::hasColumn('products', 'meta_title')) {
                $table->string('meta_title', 255)->nullable()->after('description');
            }
            if (!Schema::hasColumn('products', 'meta_description')) {
                $table->text('meta_description')->nullable()->after('meta_title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'allowed_payment_methods',
                'custom_shipping_charge',
                'weight_kg',
                'is_free_shipping',
                'meta_title',
                'meta_description'
            ]);
        });
    }
};

