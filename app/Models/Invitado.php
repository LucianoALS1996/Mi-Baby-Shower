<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitado extends Model
{
    //

    protected $table = 'invitados';
    protected $primaryKey = 'id_invitado';

    protected $fillable = [
        'id_babyshower',
        'nombre',
        'telefono',
        'email',
        'token_invitacion',
        'token_expira',
        'estado_invitacion',
        'estado_asistencia', // pendiente, confirmado, rechazado son las variables
        'canal_preferido',
        'ultimo_acceso',
        'estado',
    ];

    public function babyshower()
    {
        return $this->belongsTo(Babyshower::class, 'id_babyshower', 'id_babyshower'); // invitado pertenece a un babyshower

    }
    public function reservas()
    {
        return $this->hasMany(ReservaRegalo::class, 'id_invitado', 'id_invitado'); // invitado puede tener varias reservas
    }
    public function envios()
    {
        return $this->hasMany(InvitacionEnvio::class, 'id_invitado', 'id_invitado'); // invitado puede tener historico de envios


    }



}
