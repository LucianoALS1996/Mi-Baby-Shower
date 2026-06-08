<?php

namespace App\Http\Controllers;

use App\Models\Babyshower;
use Illuminate\Http\Request;
use App\Models\Invitado;
use Illuminate\Support\Str;
use App\Models\RegaloEvento;
use App\Models\ReservaRegalo;
use Carbon\Carbon; // para manejar fechas y horas de manera sencilla
use Illuminate\Support\Facades\Mail; // para enviar correos electronicos

class InvitadoController extends Controller
{

    public function index(int $id) // el id corresponde al babyshower
    {

        $babyshower = Babyshower::with('invitados')
            ->where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // valida que el evento sea del usuario en sesion

        return view('invitados.index', compact('babyshower'));
    }


    public function create(int $id) // lo mismo id del babyshower
    {
        $babyshower = Babyshower::with('invitados')
            ->where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // valida que pueda agregar invitados a este evento

        return view('invitados.create', compact('babyshower')); // pasamos el babyshower a la vista para mostrar su titulo y tener el id para el form
    }



    public function store(Request $request, int $id) // id del babyshower
    {
        $babyshower = Babyshower::where('id_babyshower', $id)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // valida que el babyshower exista y sea del usuario

        $request->validate([
            'nombre' => 'required',
            'telefono' => 'nullable',
            'email' => 'nullable|email'
        ]); // validar datos para crear invitado


        Invitado::create([
            'id_babyshower' => $id,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'token_invitacion' => Str::random(40),
            'token_expira' => Carbon::parse($babyshower->fecha_evento)->endOfDay(),
            'estado_invitacion' => 'pendiente',
            'estado_asistencia' => 'pendiente',
            'canal_preferido' => 'correo',
            'estado' => 'activo'
        ]); // guarda invitado con token unico y expiracion ligada al evento

        return redirect()->route('babyshowers.show', $id)->with('success', 'Invitado agregado correctamente');
    }

    public function update(Request $request, int $idBabyshower, int $idInvitado)
    {

        $babyshower = Babyshower::where('id_babyshower', $idBabyshower)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // verifica permiso sobre el evento

        $request->validate([
            'nombre' => 'required',
            'telefono' => 'nullable',
            'email' => 'nullable|email'
        ]); // valida datos actualizados del invitado

        $invitado = Invitado::where('id_babyshower', $idBabyshower)
            ->where('id_invitado', $idInvitado)
            ->firstOrFail();

        $invitado->update([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'email' => $request->email,
            'canal_preferido' => $request->canal_preferido
        ]); // actualiza informacion de contacto y canal preferido

        return redirect()->route('babyshowers.show', $idBabyshower)->with('success', 'Invitado actualizado correctamente');
    }



    
    public function destroy(int $idBabyshower, int $idInvitado)
    {
        $babyshower = Babyshower::where('id_babyshower', $idBabyshower)
            ->where('id_usuario', session('id_usuario'))
            ->firstOrFail(); // valida permiso sobre el evento

        $invitado = Invitado::where('id_babyshower', $idBabyshower)
            ->where('id_invitado', $idInvitado)
            ->firstOrFail(); // trae el invitado exacto

        // Si el invitado está activo y se va a deshabilitar
        if ($invitado->estado === 'activo') {

            $reservas = ReservaRegalo::where('id_invitado', $invitado->id_invitado)
                ->where('estado', 'activo')
                ->where('estado_reserva', 'confirmada')
                ->get(); // busca reservas confirmadas activas del invitado

            foreach ($reservas as $reserva) {

                $regalo = RegaloEvento::where('id_regalo', $reserva->id_regalo)
                    ->first();

                if ($regalo) {
                    $regalo->update([
                        'cantidad_reservada' => max(0, $regalo->cantidad_reservada - $reserva->cantidad)
                    ]); // reduce cantidad reservada al cancelar la reserva
                }

                $reserva->update([
                    'estado_reserva' => 'cancelada',
                    'estado' => 'inactivo'
                ]); // marca la reserva como cancelada
            }
        }

        $nuevoEstado = $invitado->estado === 'activo'
            ? 'inactivo'
            : 'activo';

        $invitado->update([
            'estado' => $nuevoEstado
        ]); // alterna estado activo/inactivo del invitado

        return redirect()->route('babyshowers.show', $idBabyshower)
            ->with('success', 'Estado del invitado actualizado correctamente');
    }






    public function enviarInvitacion(int $idBabyshower, int $idInvitado)
    {
        $claveCooldown = 'bloqueo_envio_invitado_' . $idInvitado;

        if (session()->has($claveCooldown)) {

            $bloqueadoHasta = session($claveCooldown);

            if (now()->lessThan($bloqueadoHasta)) {

                $segundosRestantes = (int) ceil(
                    now()->diffInRealSeconds($bloqueadoHasta)
                );

                return redirect()
                    ->route('babyshowers.invitados.index', $idBabyshower)
                    ->with('error', 'Debes esperar ' . $segundosRestantes . ' segundos antes de volver a enviar.');
            }
        }

        $invitado = Invitado::where('id_invitado', $idInvitado)
            ->where('id_babyshower', $idBabyshower)
            ->firstOrFail(); // busca invitado para enviar correo

        if (!$invitado->email) {

            return redirect()
                ->route('babyshowers.invitados.index', $idBabyshower)
                ->with('error', 'El invitado no tiene correo registrado.');
        }

        $url = url('/invitacion/' . $invitado->token_invitacion); // usa token para invitacion publica

        Mail::raw(
            "Hola {$invitado->nombre}, te invitamos al baby shower. Ingresa aquí: {$url}",
            function ($message) use ($invitado) {
                $message->to($invitado->email)
                    ->subject('Invitación Baby Shower');
            }
        ); // envia correo simple con enlace de invitacion

        session([
            $claveCooldown => now()->addSeconds(30)
        ]); // guarda cooldown en session para evitar spam inmediato

        return redirect()
            ->route('babyshowers.invitados.index', $idBabyshower)
            ->with('success', 'Invitación enviada correctamente.');
    }







    public function enviarInvitacionesMasivas(int $idBabyshower)
    {
        $claveCooldown = 'bloqueo_envio_invitaciones_' . $idBabyshower;

        if (session()->has($claveCooldown)) {

            $bloqueadoHasta = session($claveCooldown);

            if (now()->lessThan($bloqueadoHasta)) {

                $segundosRestantes = (int) ceil(now()->diffInRealSeconds($bloqueadoHasta));

                return redirect()
                    ->back()
                    ->with('error', 'Debes esperar ' . $segundosRestantes . ' segundos antes de volver a enviar.');
            }
        }

        $invitados = Invitado::where('id_babyshower', $idBabyshower)
            ->where('estado', 'activo')
            ->whereNotNull('email')
            ->get(); // selecciona invitados activos que tienen email

        if ($invitados->count() === 0) {
            return redirect()
                ->back()
                ->with('error', 'No hay invitados activos con correo.');
        }

        foreach ($invitados as $invitado) {

            $url = url('/invitacion/' . $invitado->token_invitacion); // usa token unico para cada invitacion

            Mail::raw(
                "Hola {$invitado->nombre}, te invitamos al baby shower. Ingresa aquí: {$url}",
                function ($message) use ($invitado) {
                    $message->to($invitado->email)
                        ->subject('Invitación Baby Shower');
                }
            );
        }

        session([
            $claveCooldown => now()->addSeconds(30)
        ]); // guarda cooldown masivo en session

        return redirect()
            ->back()
            ->with('success', 'Invitaciones enviadas correctamente.');
    }
}
