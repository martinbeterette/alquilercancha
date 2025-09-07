<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Complejo extends Model
{
    use SoftDeletes;

    protected $table = 'complejo';
    protected $fillable = ['nombre', 'logo'];
    
    public function sucursales() 
    {
        return $this->hasMany(Sucursal::class, 'rela_sucursal');
    }

    protected static function booted()
    {
        static::deleting(function ($complejo) {
            if (!$complejo->isForceDeleting()) {
                $complejo->sucursales()->each->delete();
            }
        });
    }
}
