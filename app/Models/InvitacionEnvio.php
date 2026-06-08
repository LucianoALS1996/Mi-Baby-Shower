<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvitacionEnvio extends Model
{
    protected $table = 'invitacion_envios';
    protected $primaryKey = 'id_envio';

    protected $fillable = ['id_invitado','canal','fecha_envio','estado_envio','estado'];

    public function invitado()
    {
        return $this->belongsTo(Invitado::class,'id_invitado','id_invitado'); // envio pertenece a un invitado
    }
}
