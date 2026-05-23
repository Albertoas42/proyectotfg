<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('title', 100);
            $table->text('description');
            $table->decimal('price', 6, 2);
            $table->enum('item_condition', ['new', 'good', 'worn']);
            $table->enum('status', ['available', 'reserved', 'sold'])->default('available');
            $table->string('image_url', 255)->default('default_product.png');

            $table->unsignedBigInteger('seller_id');
            $table->unsignedBigInteger('buyer_id')->nullable();
            $table->unsignedBigInteger('category_id');

            $table->foreign('seller_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('buyer_id')->references('user_id')->on('users')->onDelete('set null');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('restrict');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
