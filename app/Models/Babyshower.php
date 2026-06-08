<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Babyshower extends Model
{
    //
    protected $table = 'babyshowers';
    protected $primaryKey = 'id_babyshower';

    protected $fillable = [
        'id_usuario',
        'titulo',
        'fecha_evento',
        'lugar',
        'descripcion',
        'portada_url',
        'estado'
    ];

    public function usuario ()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario'); // evento pertenece a un organizador

    }
    public function invitados()
    {
        return $this->hasMany(Invitado::class, 'id_babyshower', 'id_babyshower'); // evento tiene muchos invitados

    }
    public function regalos()
    {
        return $this->hasMany(RegaloEvento::class, 'id_babyshower', 'id_babyshower'); // evento tiene muchos regalos
    }

}
