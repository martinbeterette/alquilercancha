<?php

namespace Modules\Core\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Sexo extends Model
{
    use SoftDeletes;

    protected $table = 'sexo';
    protected $fillable = ['descripcion', 'activo'];

    public function personas() 
    {
        return $this->hasMany(Persona::class, 'rela_sexo');
    }

}
