<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Tarifa extends Model
{
    use SoftDeletes;

    protected $table = 'tarifa';
    protected $fillable = [
        'nombre', 
        'hora_desde', 
        'hora_hasta', 
        'precio', 
        'observacion', 
        'rela_sucursal'
    ];

    public function sucursal() {
        return $this->belongsTo(Sucursal::class, 'rela_sucursal');
    }

}
