<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = ['chat_id', 'sender_id', 'content', 'is_read'];

    /**
     * Relación: El chat al que pertenece este mensaje.
     */
    public function chat(): BelongsTo
    {
        return $this->belongsTo(Chat::class);
    }

    /**
     * Relación: El usuario que ha enviado el mensaje.
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sender_id', 'user_id');
    }
}
