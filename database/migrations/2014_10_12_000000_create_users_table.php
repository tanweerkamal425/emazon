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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name', 32);
            $table->string('last_name', 32);
            $table->tinyInteger('gender');
            $table->string('phone', 12);
            $table->string('email', 64)->unique();
            $table->string('password', 256);
            $table->tinyInteger('is_active')->default(0);
            $table->tinyInteger('is_blocked')->default(0);
            $table->string('image_url', 256)->nullable();
            $table->unsignedBigInteger('address_id')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            $table->index('first_name', 'last_name');
            $table->index('phone');
            $table->index('email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
