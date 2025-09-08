<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Membresia extends Model
{
    use SoftDeletes;

    protected $fillable = ['complejo_id', 'nombre', 'descripcion', 'precio', 'descuento_base'];

    public function complejo()
    {
        return $this->belongsTo(Complejo::class);
    }

    public function promociones()
    {
        return $this->hasMany(Promocion::class);
    }

    // 📌 Método para calcular el precio con descuento activo
    public function precioConDescuento()
    {
        $precioFinal = $this->precio;

        // aplicar descuento base
        if ($this->descuento_base > 0) {
            $precioFinal -= ($precioFinal * $this->descuento_base / 100);
        }

        // buscar promociones activas
        $promocion = $this->promociones()
            ->where('activo', true)
            ->whereDate('fecha_inicio', '<=', now())
            ->whereDate('fecha_fin', '>=', now())
            ->first();

        if ($promocion) {
            if ($promocion->tipo_descuento === 'porcentaje') {
                $precioFinal -= ($precioFinal * $promocion->valor_descuento / 100);
            } else {
                $precioFinal -= $promocion->valor_descuento;
            }
        }

        return max($precioFinal, 0); // nunca menor a 0
    }
}
