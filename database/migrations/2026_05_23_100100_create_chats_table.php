<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id(); // Usamos 'id' estándar (Laravel lo ama)

            // Relación con tu tabla de productos (asumiendo que tu clave es product_id)
            $table->foreignId('product_id')->constrained('products', 'product_id')->onDelete('cascade');

            // Relación con los usuarios (asumiendo que tu clave es user_id)
            $table->foreignId('buyer_id')->constrained('users', 'user_id')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users', 'user_id')->onDelete('cascade');

            $table->timestamps();

            // Evitamos que el mismo comprador abra dos chats distintos para el mismo producto
            $table->unique(['product_id', 'buyer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
