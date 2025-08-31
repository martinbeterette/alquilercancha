<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Barrio extends Model
{
    protected $fillable = ['descripcion', 'rela_localidad'];
    protected $table = "barrio";
    use SoftDeletes;

    public function localidad()
    {
        return $this->belongsTo(Localidad::class, 'rela_localidad');
    }

    
}
