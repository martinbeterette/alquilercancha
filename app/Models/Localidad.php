<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Localidad extends Model
{
    use SoftDeletes;
    protected $fillable = ['descripcion','rela_provincia'];
    protected $table    = "localidad";

    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'rela_provincia');
    }
}
