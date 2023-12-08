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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code', 255)->unique();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('total');
            $table->integer('final_total');
            $table->enum('payment_method', ['online', 'cod']);
            $table->integer('payment_status')->default(0);
            $table->enum('order_status', ['Đã Đặt Hàng', 'Đang Giao Hàng', 'Đã Giao Hàng', 'Hoàn Thành']);
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 12);
            $table->string('post_code', 255)->nullable();
            $table->string('address', 550);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
