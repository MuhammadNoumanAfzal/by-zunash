<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // 1. Personalization / Name Engraving
            if (!Schema::hasColumn('products', 'has_engraving')) {
                $table->boolean('has_engraving')->default(false)->after('colors');
            }
            if (!Schema::hasColumn('products', 'engraving_price')) {
                $table->decimal('engraving_price', 10, 2)->default(0.00)->after('has_engraving');
            }
            if (!Schema::hasColumn('products', 'engraving_placeholder')) {
                $table->string('engraving_placeholder')->nullable()->after('engraving_price');
            }
            if (!Schema::hasColumn('products', 'engraving_note')) {
                $table->string('engraving_note')->nullable()->after('engraving_placeholder');
            }

            // 2. Add-ons Cross-Sell ("Add these & get extra 15% off")
            if (!Schema::hasColumn('products', 'has_addons')) {
                $table->boolean('has_addons')->default(false)->after('engraving_note');
            }
            if (!Schema::hasColumn('products', 'addon_product_ids')) {
                $table->json('addon_product_ids')->nullable()->after('has_addons');
            }
            if (!Schema::hasColumn('products', 'addon_discount_percent')) {
                $table->integer('addon_discount_percent')->default(15)->after('addon_product_ids');
            }

            // 3. Gift Set / Bundle Upgrade ("Buying it as a gift? Get the Set instead")
            if (!Schema::hasColumn('products', 'has_gift_set')) {
                $table->boolean('has_gift_set')->default(false)->after('addon_discount_percent');
            }
            if (!Schema::hasColumn('products', 'gift_deal_id')) {
                $table->unsignedBigInteger('gift_deal_id')->nullable()->after('has_gift_set');
            }
            if (!Schema::hasColumn('products', 'gift_set_title')) {
                $table->string('gift_set_title')->nullable()->after('gift_deal_id');
            }
            if (!Schema::hasColumn('products', 'gift_set_subtitle')) {
                $table->string('gift_set_subtitle')->nullable()->after('gift_set_title');
            }
            if (!Schema::hasColumn('products', 'gift_set_price')) {
                $table->decimal('gift_set_price', 10, 2)->nullable()->after('gift_set_subtitle');
            }
            if (!Schema::hasColumn('products', 'gift_set_original_price')) {
                $table->decimal('gift_set_original_price', 10, 2)->nullable()->after('gift_set_price');
            }
            if (!Schema::hasColumn('products', 'gift_set_image')) {
                $table->string('gift_set_image')->nullable()->after('gift_set_original_price');
            }

            // 4. WhatsApp Reviews / Social Proof
            if (!Schema::hasColumn('products', 'whatsapp_reviews')) {
                $table->json('whatsapp_reviews')->nullable()->after('gift_set_image');
            }
        });

        Schema::table('reviews', function (Blueprint $table) {
            if (!Schema::hasColumn('reviews', 'is_whatsapp')) {
                $table->boolean('is_whatsapp')->default(false)->after('verified');
            }
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'has_engraving',
                'engraving_price',
                'engraving_placeholder',
                'engraving_note',
                'has_addons',
                'addon_product_ids',
                'addon_discount_percent',
                'has_gift_set',
                'gift_deal_id',
                'gift_set_title',
                'gift_set_subtitle',
                'gift_set_price',
                'gift_set_original_price',
                'gift_set_image',
                'whatsapp_reviews',
            ]);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropColumn(['is_whatsapp']);
        });
    }
};
