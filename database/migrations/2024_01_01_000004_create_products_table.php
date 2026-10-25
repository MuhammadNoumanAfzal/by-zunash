<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('category_slug')->default('belts');
            $table->string('category_name')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('original_price', 10, 2)->nullable();
            $table->string('sku')->nullable()->unique();
            $table->string('badge')->nullable(); // 'Bestseller', 'New Arrival', 'Masterpiece', etc.
            $table->boolean('is_bestseller')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('in_stock')->default(true);
            $table->string('availability')->default('in_stock'); // 'in_stock', 'out_of_stock', 'on_demand'
            $table->integer('stock_quantity')->default(15);
            $table->float('rating', 3, 2)->default(5.0);
            $table->integer('reviews_count')->default(0);
            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->string('image')->nullable();
            $table->json('gallery')->nullable();
            $table->json('features')->nullable();
            $table->json('specifications')->nullable();
            $table->json('colors')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
