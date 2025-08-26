<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class EstadoPago extends Model
{
    use SoftDeletes;
    protected $table = 'estado_pago';

    protected $fillable = [
        'descripcion',
    ];
}
