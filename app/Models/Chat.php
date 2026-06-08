<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Chat extends Model
{
    // Permitimos la asignación masiva de estos campos
    protected $fillable = ['product_id', 'buyer_id', 'seller_id'];

    /**
     * Relación: El producto del que se habla en el chat.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    /**
     * Relación: El alumno que quiere comprar.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id', 'user_id');
    }

    /**
     * Relación: El alumno que vende el producto.
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id', 'user_id');
    }

    /**
     * Relación: Todos los mensajes de la conversación.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Relación: El último mensaje del chat (para la lista del inbox).
     */
    public function lastMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}
