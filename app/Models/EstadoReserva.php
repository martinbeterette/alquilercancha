<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstadoReserva extends Model
{
    use SoftDeletes;

    protected $fillable = ['descripcion'];
    protected $table = 'estado_reserva';

    public function reservas() 
    {
        return $this->hasMany(Reserva::class, 'rela_estado_reserva');
    }
}
