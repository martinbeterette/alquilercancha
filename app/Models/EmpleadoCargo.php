<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmpleadoCargo extends Model
{
    use SoftDeletes;

    protected $fillable = ['descripcion'];

    public function empleados()
    {
        return $this->hasMany(Empleado::class, 'cargo_id');
    }
}
