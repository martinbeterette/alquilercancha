<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoContacto extends Model
{
    
    use SoftDeletes;
    protected $table = 'tipo_contacto';
    protected $fillable = ['descripcion', 'activo'];

    public function contactos() 
    {
        return $this->hasMany(Contacto::class, 'rela_tipo_contacto');
    }
}
