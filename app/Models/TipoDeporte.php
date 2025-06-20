<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoDeporte extends Model
{
    use SoftDeletes;
    //
    protected $table = 'tipo_deporte';
    protected $fillable = ['descripcion', 'activo', 'rela_deporte'];

    public function deporte() 
    {
        return $this->belongsTo(Deporte::class, 'rela_deporte');
    }


}
