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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amount');
            $table->string('order_group_id', 64);
            $table->string('pg_payment_id', 64);
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('mode')->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->index('order_group_id');
            $table->index('pg_payment_id');
            $table->index('user_id');

            $table->foreign("user_id")->references("id")->on("users");



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
