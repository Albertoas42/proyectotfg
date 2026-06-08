<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // <-- 1. IMPORTA EL TRAIT AQUÍ

class Review extends Model
{
    use HasFactory; // <-- 2. ACTIVA EL TRAIT AQUÍ

    protected $primaryKey = 'review_id';
    protected $fillable = ['product_id', 'reviewer_id', 'reviewee_id', 'rating', 'comment'];

    // El producto asociado a la valoración
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // El usuario que hizo la valoración (Comprador)
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id', 'user_id');
    }

    // El usuario dueño del perfil valorado (Vendedor)
    public function reviewee()
    {
        return $this->belongsTo(User::class, 'reviewee_id', 'user_id');
    }
}
