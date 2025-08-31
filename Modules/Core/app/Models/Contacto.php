<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    //
    protected $table = 'contacto';
    protected $fillable = ['descripcion', 'activo', 'rela_persona', 'rela_tipo_contacto'];

    public function persona() 
    {
        return $this->belongsTo(Persona::class, 'rela_persona');
    }

    public function tipoContacto() 
    {
        return $this->belongsTo(TipoContacto::class, 'rela_tipo_contacto');
    }
}
