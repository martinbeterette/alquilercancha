<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;

class Modulo extends Model
{
    protected $fillable = ['name', 'slug', 'icon', 'orden'];

    // Relación con roles (muchos a muchos)
    public function roles()
    {
        return $this->belongsToMany(Perfil::class, 'modulo_role','modulo_id', 'role_id'); // pivot table
    }
}
