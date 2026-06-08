<?php

namespace App\Http\Controllers;

use App\Models\Invitado;
use Illuminate\Http\Request;
use App\Models\RegaloEvento;
use App\Models\ReservaRegalo;

class InvitacionPublicaController extends Controller
{


    public function show(string $token)
    {
        $invitado = Invitado::with(['babyshower.regalos', 'reservas.regalo'])
            ->where('token_invitacion', $token)
            ->where('estado', 'activo')
            ->where('token_expira', '>=', now())
            ->firstOrFail(); // busca invitado valido por token y expiracion

        if ($invitado->babyshower->estado !== 'activo') {
            abort(403, 'Este evento no se encuentra disponible.'); // evita acceso a eventos inactivos
        }

        $invitado->update([
            'ultimo_acceso' => now() // acutaliza ultimo acceso para saber si el invitado entro a la invitacion
        ]);


        return view('invitaciones.show', compact('invitado'));
    }

    public function confirmar(string $token)
    {
        $invitado = $this->obtenerInvitadoValido($token); // valida token y estado del evento

        $invitado->update([
            'estado_asistencia' => 'confirmado'
        ]); // marca asistente como confirmado

        return redirect()->route('invitacion.show', $token)
            ->with('success', 'Asistencia confirmada correctamente');
    }

    public function rechazar(string $token)
    {
        $invitado = $this->obtenerInvitadoValido($token); // valida token y disponibilidad

        $reservas = ReservaRegalo::where('id_invitado', $invitado->id_invitado)
            ->where('estado', 'activo')
            ->where('estado_reserva', 'confirmada')
            ->get(); // busca reservas activas confirmadas

        foreach ($reservas as $reserva) {
            $regalo = RegaloEvento::find($reserva->id_regalo);

            if ($regalo) {
                $regalo->update([
                    'cantidad_reservada' => max(0, $regalo->cantidad_reservada - $reserva->cantidad)
                ]); // libera cantidad reservada del regalo
            }

            $reserva->update([
                'estado_reserva' => 'cancelada',
                'estado' => 'inactivo'
            ]); // marca reserva como cancelada
        }

        $invitado->update([
            'estado_asistencia' => 'pendiente'
        ]); // deja asistencia en pendiente

        return redirect()->route('invitacion.show', $token)
            ->with('success', 'Tu asistencia quedó pendiente y tus reservas fueron liberadas');
    }


    public function reservarRegalo(Request $request, string $token, int $idRegalo)
    {
        $request->validate([
            'cantidad' => 'required|integer|min:1'
        ]); // valida la cantidad solicitada

        $invitado = $this->obtenerInvitadoValido($token); // valida token y evento

        $regalo = RegaloEvento::where('id_regalo', $idRegalo)
            ->where('id_babyshower', $invitado->id_babyshower)
            ->where('estado', 'activo')
            ->firstOrFail(); // valida regalo activo del evento

        $disponibles = $regalo->cantidad_sugerida - $regalo->cantidad_reservada;
        $cantidad = (int) $request->cantidad;

        if ($cantidad > $disponibles) {
            return redirect()->route('invitacion.show', $token)
                ->with('success', 'No hay suficiente cantidad disponible para este regalo');
        }

        ReservaRegalo::create([
            'id_regalo' => $regalo->id_regalo,
            'id_invitado' => $invitado->id_invitado,
            'cantidad' => $cantidad,
            'fecha_reserva' => now(),
            'estado_reserva' => 'confirmada',
            'estado' => 'activo'
        ]); // crea reserva activa para el invitado

        $regalo->update([
            'cantidad_reservada' => $regalo->cantidad_reservada + $cantidad
        ]); // actualiza cantidad reservada en el regalo

        return redirect()->route('invitacion.show', $token)
            ->with('success', 'Regalo reservado correctamente');
    }

    public function revertirReserva(string $token, int $idReserva)
    {
        $invitado = $this->obtenerInvitadoValido($token); // valida token del invitado

        $reserva = ReservaRegalo::where('id_reserva', $idReserva)
            ->where('id_invitado', $invitado->id_invitado)
            ->where('estado', 'activo')
            ->where('estado_reserva', 'confirmada')
            ->firstOrFail(); // busca reserva activa y confirmada

        $regalo = RegaloEvento::where('id_regalo', $reserva->id_regalo)
            ->firstOrFail();

        $regalo->update([
            'cantidad_reservada' => max(0, $regalo->cantidad_reservada - $reserva->cantidad)
        ]); // resta cantidad reservada cuando se revierte

        $reserva->update([
            'estado_reserva' => 'cancelada',
            'estado' => 'inactivo'
        ]); // marca reserva como cancelada

        return redirect()->route('invitacion.show', $token)
            ->with('success', 'Reserva revertida correctamente');
    }
    private function obtenerInvitadoValido(string $token)
    {
        $invitado = Invitado::with('babyshower')
            ->where('token_invitacion', $token)
            ->where('estado', 'activo')
            ->where('token_expira', '>=', now())
            ->firstOrFail(); // valida token, estado e inicio de invitado

        if ($invitado->babyshower->estado !== 'activo') {
            abort(403, 'Este evento no se encuentra disponible.'); // evento debe estar activo
        }

        return $invitado;
    }
}
