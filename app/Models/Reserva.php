<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reserva extends Model
{
    use SoftDeletes;
    protected $table    = "reserva";
    protected $fillable = [
        'observacion', 
        'fecha', 
        'hora_desde', 
        'hora_hasta', 
        'precio', 
        'estado', 
        'metodo_pago',
        'tipo_reserva',
        'cancelacion_motivo',
        'creado_por',
        'rela_persona',
        'rela_zona',
    ];
    //
    public function persona(){
        return $this->belongsTo(Persona::class, 'rela_persona');
    }

    public function zona() {
        return $this->belongsTo(Zona::class, 'rela_zona');
    }
}
