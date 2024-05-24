<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            // $table->unsignedBigInteger('cart_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('qty');
            $table->unsignedBigInteger('price_mp')->default(0);
            $table->unsignedBigInteger('price_sp')->default(0);
            $table->unsignedBigInteger('discount')->default(0);
            $table->tinyInteger('status')->default(0);
            $table->unsignedSmallInteger('flags')->default(0);
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('dilivered_at')->nullable();
            $table->timestamp('cancellation_requested_at')->nullable();
            $table->timestamp('cancealled_at')->nullable();
            $table->timestamp('return_requested_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamp('refund_requested_at')->nullable();
            $table->timestamp('refunded_at')->nullable();

            $table->foreign('order_id')->references('id')->on('orders');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('user_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
