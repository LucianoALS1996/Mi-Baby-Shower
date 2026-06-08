<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'rol',
        'estado'
    ];

    protected $hidden = [
        'password',
    ];

    public function babyshowers()
    {
        return $this->hasMany(Babyshower::class, 'id_usuario', 'id_usuario'); // usuario puede tener varios eventos
    }
}
