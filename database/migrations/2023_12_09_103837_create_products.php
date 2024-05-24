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
            $table->string('code')->unique();
            $table->string('title');
            $table->string('subtitle', 512);
            $table->string('description',  1024)->nullable();
            $table->Integer('price_mp');
            $table->Integer('price_sp');
            $table->string('slug')->unique();
            $table->string('image_url');
            $table->unsignedBigInteger('category_id');
            $table->tinyInteger('is_returnable')->default(0);
            $table->tinyInteger('is_published')->default(0);

            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamp('published_at')->nullable();

            $table->foreign('category_id')->references('id')->on('categories');
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
