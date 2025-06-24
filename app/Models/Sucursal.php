<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use SoftDeletes;
    protected $table = 'sucursal';
    protected $fillable = ['nombre', 'direccion', 'rela_complejo'];
    //
    public function complejo()
    {
        return $this->belongsTo(Complejo::class, 'rela_complejo');
    }

    public function zonas()
    {
        return $this->hasMany(Zona::class, 'rela_sucursal');
    }
}
