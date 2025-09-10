<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Empleado extends Model
{
    use SoftDeletes;

    protected $fillable = ['nombre', 'sucursal_id', 'cargo_id'];

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function cargo()
    {
        return $this->belongsTo(EmpleadoCargo::class, 'cargo_id');
    }
}
