<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegaloEvento extends Model
{
    protected $table = 'regalo_eventos';
    protected $primaryKey = 'id_regalo';

    protected $fillable = [
        'id_babyshower',
        'nombre',
        'descripcion',
        'imagen_url',
        'cantidad_sugerida',
        'cantidad_reservada',
        'origen_regalo',
        'estado'
    ];


    public function babyshower()
    {
        return $this->belongsTo(Babyshower::class,'id_babyshower','id_babyshower'); // regalo pertenece a un babyshower
    }


    public function reservas()
    {
        return $this->hasMany(ReservaRegalo::class,'id_regalo','id_regalo'); // regalo tiene muchas reservas
    }
}
