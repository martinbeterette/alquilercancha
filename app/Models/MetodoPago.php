<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class MetodoPago extends Model
{
    use SoftDeletes;
    protected $table = 'metodo_pago';

    protected $fillable = [
        'descripcion',
    ];
}
