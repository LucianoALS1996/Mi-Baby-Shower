<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReservaRegalo extends Model
{
    protected $table = 'reserva_regalos';
    protected $primaryKey = 'id_reserva';

    protected $fillable = [
        'id_reserva',
        'id_regalo',
        'id_invitado',
        'cantidad',
        'fecha_reserva',
        'estado_reserva',
        'estado'
    ];

    public function regalo()
    {
        return $this->belongsTo(RegaloEvento::class,'id_regalo','id_regalo'); // reserva pertenece a un regalo
    }

    public function invitado()
    {
        return $this->belongsTo(Invitado::class,'id_invitado','id_invitado'); // reserva pertenece a un invitado
    }





}
