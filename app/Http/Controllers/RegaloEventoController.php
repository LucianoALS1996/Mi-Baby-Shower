<?php

namespace App\Http\Controllers;

use App\Models\Babyshower;
use App\Models\RegaloEvento;
use Illuminate\Http\Request;
use App\Models\ReservaRegalo;

class RegaloEventoController extends Controller
{
    public function index(int $id)
    {
        $babyshower = Babyshower::with('regalos')
            ->where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail();

        return view('regalos.index', compact('babyshower'));
    }




    public function create(int $id)
    {
        $babyshower = Babyshower::where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail();

        return view('regalos.create', compact('babyshower'));
    }




    public function store(Request $request, int $id)
    {

        Babyshower::where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // valida que el evento exista y sea del usuario

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'cantidad_sugerida' => 'required|integer|min:1'
        ]); // valida datos del regalo

        RegaloEvento::create([
            'id_babyshower' => $id,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'cantidad_sugerida' => $request->cantidad_sugerida,
            'cantidad_reservada' => 0,
            'origen_regalo' => 'manual',
            'estado' => 'activo'
        ]); // guarda regalo con stock inicial en cero

        return redirect()->route('babyshowers.show', $id)->with('success', 'Regalo agregado correctamente');
    }




    public function edit(int $idBabyshower, int $idRegalo)
    {
        $babyshower = Babyshower::where('id_babyshower', $idBabyshower)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // valida permisos para editar

        $regalo = RegaloEvento::where('id_babyshower', $idBabyshower)
            ->where('id_regalo', $idRegalo)
            ->firstOrFail(); // obtiene el regalo del evento

        return view('regalos.edit', compact('babyshower', 'regalo'));
    }




    public function update(Request $request, int $idBabyshower, int $idRegalo)
    {

        Babyshower::where('id_babyshower', $idBabyshower)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // valida que el usuario pueda editar este evento

        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'nullable',
            'cantidad_sugerida' => 'required|integer|min:1'
        ]); // valida los datos del regalo

        $regalo = RegaloEvento::where('id_babyshower', $idBabyshower)
            ->where('id_regalo', $idRegalo)
            ->firstOrFail();

        $regalo->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'cantidad_sugerida' => $request->cantidad_sugerida
        ]); // actualiza informacion del regalo

        return redirect()->route('babyshowers.show', $idBabyshower)->with('success', 'Regalo actualizado correctamente');
    }




    public function destroy(int $idBabyshower, int $idRegalo)
    {
        Babyshower::where('id_babyshower', $idBabyshower)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // valida permisos para deshabilitar o habilitar

        $regalo = RegaloEvento::where('id_babyshower', $idBabyshower)
            ->where('id_regalo', $idRegalo)
            ->firstOrFail();

        $nuevoEstado = $regalo->estado === 'activo' ? 'inactivo' : 'activo';

        $regalo->update([
            'estado' => $nuevoEstado
        ]); // cambia estado sin borrar el registro

        return redirect()
            ->route('babyshowers.regalos.index', $idBabyshower)
            ->with('success', 'Estado del regalo actualizado correctamente.');
    }
}
