<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author');
            $table->string('city')->nullable();
            $table->string('initials', 10)->nullable();
            $table->string('category')->nullable();
            $table->string('product_name');
            $table->string('product_slug')->nullable();
            $table->integer('rating')->default(5);
            $table->string('title');
            $table->text('comment');
            $table->string('image')->nullable();
            $table->integer('helpful')->default(0);
            $table->boolean('verified')->default(true);
            $table->string('status')->default('published'); // published, pending, rejected
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
