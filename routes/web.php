<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BabyshowerController;
use App\Http\Controllers\InvitadoController;
use App\Http\Controllers\RegaloEventoController;
use App\Http\Controllers\InvitacionPublicaController;
use App\Http\Controllers\AuthController;

// rutas publicas
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::post('/login', [AuthController::class, 'autenticar'])->name('login.autenticar');

Route::get('/recuperar-password', [AuthController::class, 'mostrarRecuperarPassword'])->name('password.recuperar');
Route::post('/recuperar-password', [AuthController::class, 'enviarCorreoRecuperacion'])->name('password.enviar');
Route::get('/nueva-password/{token}', [AuthController::class, 'mostrarNuevaPassword'])->name('password.nueva');
Route::post('/nueva-password', [AuthController::class, 'guardarNuevaPassword'])->name('password.guardar');


// invitaciones publicas
Route::get('/invitacion/{token}', [InvitacionPublicaController::class, 'show'])->name('invitacion.show');
Route::post('/invitacion/{token}/confirmar', [InvitacionPublicaController::class, 'confirmar'])->name('invitacion.confirmar');
Route::post('/invitacion/{token}/rechazar', [InvitacionPublicaController::class, 'rechazar'])->name('invitacion.rechazar');
Route::post('/invitacion/{token}/reservar/{idRegalo}', [InvitacionPublicaController::class, 'reservarRegalo'])->name('invitacion.reservarRegalo');
Route::post('/invitacion/{token}/revertir/{idReserva}', [InvitacionPublicaController::class, 'revertirReserva'])->name('invitacion.revertirReserva');

// rutas protegidas con sesion
Route::middleware('auth.manual')->group(function () {

    Route::get('/babyshowers', [BabyshowerController::class, 'index'])->name('babyshowers.index');
    Route::get('/babyshowers/create', [BabyshowerController::class, 'create'])->name('babyshowers.create');
    Route::post('/babyshowers', [BabyshowerController::class, 'store'])->name('babyshowers.store');
    Route::get('/babyshowers/{id}', [BabyshowerController::class, 'show'])->name('babyshowers.show');
    Route::get('/babyshowers/{id}/edit', [BabyshowerController::class, 'edit'])->name('babyshowers.edit');
    Route::put('/babyshowers/{id}', [BabyshowerController::class, 'update'])->name('babyshowers.update');
    Route::delete('/babyshowers/{id}', [BabyshowerController::class, 'destroy'])->name('babyshowers.destroy');


    Route::get('/babyshowers/{id}/invitados', [InvitadoController::class, 'index'])->name('babyshowers.invitados.index');
    Route::get('/babyshowers/{id}/invitados/create', [InvitadoController::class, 'create'])->name('babyshowers.invitados.create');
    Route::post('/babyshowers/{id}/invitados', [InvitadoController::class, 'store'])->name('babyshowers.invitados.store');
    Route::put('/babyshowers/{idBabyshower}/invitados/{idInvitado}', [InvitadoController::class, 'update'])->name('babyshowers.invitados.update');
    Route::delete('/babyshowers/{idBabyshower}/invitados/{idInvitado}', [InvitadoController::class, 'destroy'])->name('babyshowers.invitados.destroy');
    Route::post('/babyshowers/{idBabyshower}/invitados/{idInvitado}/enviar', [InvitadoController::class, 'enviarInvitacion'])->name('babyshowers.invitados.enviar');
    Route::post('/babyshowers/{idBabyshower}/invitados/enviar-masivo', [InvitadoController::class, 'enviarInvitacionesMasivas'])->name('babyshowers.invitados.enviarMasivo');

    Route::get('/babyshowers/{id}/regalos', [RegaloEventoController::class, 'index'])->name('babyshowers.regalos.index');
    Route::get('/babyshowers/{id}/regalos/create', [RegaloEventoController::class, 'create'])->name('babyshowers.regalos.create');
    Route::post('/babyshowers/{id}/regalos', [RegaloEventoController::class, 'store'])->name('babyshowers.regalos.store');
    Route::get('/babyshowers/{idBabyshower}/regalos/{idRegalo}/edit', [RegaloEventoController::class, 'edit'])->name('babyshowers.regalos.edit');
    Route::put('/babyshowers/{idBabyshower}/regalos/{idRegalo}', [RegaloEventoController::class, 'update'])->name('babyshowers.regalos.update');
    Route::delete('/babyshowers/{idBabyshower}/regalos/{idRegalo}', [RegaloEventoController::class, 'destroy'])->name('babyshowers.regalos.destroy');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
