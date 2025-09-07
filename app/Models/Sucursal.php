<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use SoftDeletes;

    protected $table = 'sucursal';
    protected $fillable = ['nombre', 'direccion', 'rela_complejo'];
    
    public function complejo()
    {
        return $this->belongsTo(Complejo::class, 'rela_complejo');
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'sucursal_id');
    }

    public function zonas()
    {
        return $this->hasMany(Zona::class, 'rela_sucursal');
    }

    protected static function booted()
    {
        static::deleting(function ($sucursal) {
            if (!$sucursal->isForceDeleting()) {
                $sucursal->empleados()->each->delete();
                $sucursal->zonas()->each->delete();
            }
        });
    }
}
