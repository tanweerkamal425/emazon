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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->string('title', 64);
            $table->string('full_name', 64);
            $table->string('phone', 12);
            $table->string('address_line_1', 128);
            $table->unsignedBigInteger('town_id');
            $table->unsignedBigInteger('user_id');
            
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->index('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
