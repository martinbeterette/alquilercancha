<?php

namespace Modules\Core\Models;

// DESCARTABLE CUANDO MIGRE A MODULES
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    //
    use HasFactory , SoftDeletes;

    protected $table = 'persona';
    protected $fillable = ['nombre', 'apellido', 'fecha_nacimiento', 'rela_sexo'];


    public function users()
    {
        return $this->hasMany(User::class, 'rela_persona');
    }
    
    public function documentos() 
    {
        return $this->hasOne(Documento::class, 'rela_persona');
    }

    public function contactos() 
    {
        return $this->hasMany(Contacto::class, 'rela_persona');
    }

    public function sexo() 
    {
        return $this->belongsTo(Sexo::class, 'rela_sexo');
    }

    public static function buscarPersona($contacto)
    {
        if (!$contacto) return null;

        return self::where("contacto", "LIKE", "%{$contacto}%")->first();
    }
}
