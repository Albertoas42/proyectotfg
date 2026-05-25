<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;

    protected $primaryKey = 'product_id'; // Ajusta si en tu migración es 'id' o 'product_id'

    protected $fillable = [
        'title',
        'description',
        'price',
        'image_url',
        'status', // 'available', 'reserved', 'sold'
        'category_id',
        'seller_id',
        'buyer_id',
    ];

    /**
     * El producto pertenece a un vendedor (Usuario).
     */
    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    /**
     * El producto puede tener un comprador (Usuario) o ser null si está libre.
     */
    public function buyer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    /**
     * El producto pertenece a una categoría específica.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
