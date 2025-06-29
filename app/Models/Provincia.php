<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Provincia extends Model
{
    use SoftDeletes;

    protected $fillable = ['descripcion'];
    protected $table    = 'provincia';

    public function localidades()
    {
        return $this->hasMany(Localidad::class, 'rela_provincia');
    }
}
