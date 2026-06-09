<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    // Si en tu migración pusiste $table->id('user_id'), Laravel necesita saber que no se llama 'id'
    protected $primaryKey = 'user_id';

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    /**
     * Un usuario puede tener muchos productos en venta.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    /**
     * Un usuario puede haber comprado/reservado muchos productos.
     */
    public function purchases(): HasMany
    {
        return $this->hasMany(Product::class, 'buyer_id');
    }

    /**
     * Mensajes enviados por el usuario.
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * Mensajes recibidos por el usuario.
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }
    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'user_id')->withDefault([
            'bio' => 'Este usuario aún no ha escrito una biografía.',
            'course' => 'Alumno del centro',
            'is_verified' => false
        ]);
    }

    public function reviewsReceived()
    {
        return $this->hasMany(Review::class, 'reviewee_id', 'user_id');
    }

    public function reviewsWritten()
    {
        return $this->hasMany(Review::class, 'reviewer_id', 'user_id');
    }

    public function averageRating()
    {
        return $this->reviewsReceived()->avg('rating') ?? 0;
    }
    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id')->withTimestamps();
    }
}
