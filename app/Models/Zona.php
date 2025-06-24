<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zona extends Model
{
    use SoftDeletes;
    
    protected $table = 'zona';
    protected $fillable = [
        'descripcion',
        'dimension', 
        'rela_superficie', 
        'rela_tipo_zona',
        'rela_tipo_deporte', 
        'rela_sucursal',
        'rela_estado_zona',
        'activo', 
    ];
    //
    public function sucursales()
    {
        return $this->belongsTo(Sucursal::class, 'rela_sucursal');
    }

    public function tipoZona()
    {
        return $this->belongsTo(TipoZona::class, 'rela_tipo_zona');
    }

    public function superficie()
    {
        return $this->belongsTo(Superficie::class, 'rela_superficie');
    }

    public function tipoDeporte()
    {
        return $this->belongsTo(TipoDeporte::class, 'rela_tipo_deporte');
    }

    public function estadoZona()
    {
        return $this->belongsTo(EstadoZona::class, 'rela_estado_zona');
    }
}
