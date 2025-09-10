<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promocion extends Model
{
    use SoftDeletes;

    protected $table = 'promociones';

    protected $fillable = [
        'complejo_id',
        'membresia_id',
        'nombre',
        'descripcion',
        'tipo_descuento',
        'valor_descuento',
        'fecha_inicio',
        'fecha_fin',
        'activo'
    ];

    public function complejo()
    {
        return $this->belongsTo(Complejo::class);
    }

    public function membresia()
    {
        return $this->belongsTo(Membresia::class);
    }

    // scope para promos vigentes
    public function scopeVigentes($query)
    {
        return $query->where('activo', true)
            ->whereDate('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now());
    }
}
