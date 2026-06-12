<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'item_condition',
        'image_url',
        'status',
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

    public function isFavoritedBy($user)
    {
        if (!$user) return false;
        return \DB::table('favorites')
            ->where('user_id', $user->user_id) // cambia a id si tu PK es id
            ->where('product_id', $this->product_id)
            ->exists();
    }
    public function scopeSearch(Builder $query, $term): Builder
    {
        if (empty($term)) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
                ->orWhere('description', 'like', "%{$term}%");
        });
    }

    /**
     * Filtra por categoría si el usuario selecciona una en el desplegable
     */
    public function scopeOfCategory(Builder $query, $categoryId): Builder
    {
        if (empty($categoryId)) return $query;

        return $query->where('category_id', $categoryId);
    }

    /**
     * Filtra por el estado físico del producto (new, good, worn)
     */
    public function scopeOfCondition(Builder $query, $condition): Builder
    {
        if (empty($condition)) return $query;

        return $query->where('item_condition', $condition);
    }

    /**
     * Filtra por un rango de precio (Mínimo y Máximo)
     */
    public function scopePriceBetween(Builder $query, $minPrice, $maxPrice): Builder
    {
        if (filled($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }

        if (filled($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }

    /**
     * Muestra solo los anuncios disponibles (evita los reservados o vendidos)
     */
    public function scopeAvailable(Builder $query): Builder
    {
        return $query->where('status', 'available');
    }
    public function isReserved()
    {
        return $this->status === 'reserved';
    }

// Saber si está vendido
    public function isSold()
    {
        return $this->status === 'sold';
    }
}
