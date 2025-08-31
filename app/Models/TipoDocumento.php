<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoDocumento extends Model
{
    //

    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'tipo_documento';
    protected $fillable = ['descripcion', 'activo'];

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'rela_tipo_documento');
    }
}
