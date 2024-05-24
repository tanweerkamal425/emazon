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
        Schema::create('pg_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amount');
            $table->string('order_group_id', 64);
            $table->string('pg_payment_id', 128)->default(null);
            $table->string('pg_order_id', 128)->default(null);
            $table->tinyInteger('mode')->default(null);
            $table->tinyInteger('status')->default(0);

            $table->index('order_group_id');
            $table->index('pg_payment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pg_payments');
    }
};
