<?php

namespace App\Http\Controllers;

use App\Models\Babyshower;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Invitado;

class BabyshowerController extends Controller
{

    public function index()
    {


        $babyshowers = Babyshower::with(['usuario', 'invitados', 'regalos'])
            ->where('id_usuario', session('id_usuario'))
            ->get(); // trae solo los eventos del usuario en sesion

        return view('babyshowers.index', compact('babyshowers'));
    }



    public function create()
    {


        return view('babyshowers.create'); // muestra formulario para crear evento
    }

    public function store(Request $request)
    {


        $request->validate([
            'titulo' => 'required',
            'fecha_evento' => 'required',
            'lugar' => 'required',
            'descripcion' => 'nullable'
        ]); // valida datos esenciales antes de crear el evento

        Babyshower::create([
            'id_usuario' => session('id_usuario'),
            'titulo' => $request->titulo,
            'fecha_evento' => $request->fecha_evento,
            'lugar' => $request->lugar,
            'descripcion' => $request->descripcion,
            'estado' => 'activo'
        ]); // guarda el evento asociado al usuario en sesion

        return redirect()->route('babyshowers.index')
            ->with('success', 'Baby Shower creado correctamente');
    }


    public function show(int $id)
    {


        $babyshower = Babyshower::with(['usuario', 'invitados', 'regalos'])
            ->where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // trae el evento del usuario y sus datos relacionados

        return view('babyshowers.show', compact('babyshower'));
    }



    public function edit(int $id)
    {


        $babyshower = Babyshower::where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // verifica que el evento pertenezca al usuario

        return view('babyshowers.edit', compact('babyshower'));
    }



    public function update(Request $request, int $id)
    {


        $request->validate([
            'titulo' => 'required',
            'fecha_evento' => 'required',
            'lugar' => 'required',
            'descripcion' => 'nullable'
        ]); // valida los nuevos datos del evento

        $babyshower = Babyshower::where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // obtiene el evento del usuario actual

        $babyshower->update([
            'titulo' => $request->titulo,
            'fecha_evento' => $request->fecha_evento,
            'lugar' => $request->lugar,
            'descripcion' => $request->descripcion
        ]); // actualiza datos del evento

        Invitado::where('id_babyshower', $babyshower->id_babyshower) // actualiza expiracion del token para invitados activos
            ->where('estado', 'activo')
            ->update([
                'token_expira' => Carbon::parse($request->fecha_evento)->endOfDay()
            ]);


        return redirect()->route('babyshowers.index')
            ->with('success', 'Baby Shower actualizado correctamente');
    }




    public function destroy(int $id)
    {


        $babyshower = Babyshower::where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // encuentra el evento del usuario

        $nuevoEstado = $babyshower->estado === 'activo' ? 'inactivo' : 'activo';

        $babyshower->update([
            'estado' => $nuevoEstado
        ]); // alterna el estado sin borrar fisicamente

        return redirect()->route('babyshowers.index')
            ->with('success', 'Estado del Baby Shower actualizado correctamente');
    }
}
