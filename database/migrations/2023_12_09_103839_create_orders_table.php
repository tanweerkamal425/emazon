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
            $table->string('rzp_order_id', 64)->nullable();
            // $table->string('order_group_id', 64);
            $table->integer('amount')->unsigned();
            $table->integer('gross_total')->unsigned()->default(0);
            $table->integer('sub_total')->unsigned();
            $table->integer('discount')->unsigned();
            $table->integer('tax')->unsigned()->default(0);
            $table->integer('shipment')->unsigned()->default(0);
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('applied_coupon_id')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();

            // $table->index('order_group_id');
            $table->index('created_at');
            $table->index('status');
            $table->index('user_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('applied_coupon_id')->references('id')->on('coupons');
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
