<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id('report_id');
            $table->unsignedBigInteger('reporter_id');
            $table->unsignedBigInteger('reported_product_id');
            $table->string('reason', 150);
            $table->enum('status', ['pending', 'reviewed', 'dismissed'])->default('pending');

            $table->foreign('reporter_id')->references('user_id')->on('users')->onDelete('cascade');
            $table->foreign('reported_product_id')->references('product_id')->on('products')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
