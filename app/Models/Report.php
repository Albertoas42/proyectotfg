<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Especificamos la tabla si no sigue la convención de plural (opcional)
    protected $table = 'reports';

    // Especificamos la clave primaria si no es 'id'
    protected $primaryKey = 'report_id';

    // Definimos los campos que se pueden rellenar masivamente
    protected $fillable = [
        'reporter_id',
        'reported_product_id',
        'reason',
        'status',
    ];

    /**
     * Relación: El usuario que puso el reporte
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id', 'user_id');
    }

    /**
     * Relación: El producto reportado
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'reported_product_id', 'product_id');
    }
}
