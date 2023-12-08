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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->string('summary', 500);
            $table->text('desc');
            $table->enum('status', ['normal', 'feature', 'new', 'hot'])->default('normal');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('product_code', 10)->unique();
            $table->integer('total_quantity');
            $table->integer('price');
            $table->integer('discount_price')->nullable();
            $table->integer('discount_to')->nullable();
            $table->integer('views_count')->default(0);
            $table->integer('search_count')->default(0);
            $table->integer('buy_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
