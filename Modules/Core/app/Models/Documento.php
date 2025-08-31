<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $table = 'documento';
    protected $fillable = ['descripcion', 'rela_persona', 'rela_tipo_documento', 'activo'];

    public function  persona()
    {
        return $this->belongsTo(Persona::class, 'rela_persona');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class, 'rela_tipo_documento');
    }
}
