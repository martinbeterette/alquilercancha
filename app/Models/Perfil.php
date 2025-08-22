<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role as SpatieRole;

class Perfil extends SpatieRole
{
    protected $table = 'roles'; // Mapea a la tabla de Spatie
    protected $fillable = ['name', 'guard_name']; // Lo que quieras llenar

    public $timestamps = true; // Spatie usa timestamps

    public function modulos()
    {
        return $this->belongsToMany(
            Modulo::class,
            'modulo_role', // tabla pivot
            'role_id',     // clave foránea de este modelo en la pivot
            'modulo_id'    // clave foránea del modelo relacionado
        );
    }
}
