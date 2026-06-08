<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // para manejar la tabla directo sin modelo
use Illuminate\Support\Str; // para generar tokens aleatorios
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login'); // muestra el formulario de login
    }

    public function register()
    {
        return view('auth.register'); // muestra el formulario para crear cuenta
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100',
            'email' => 'required|email|unique:usuarios,email',
            'password' => 'required|min:6|confirmed'
        ]); // valida datos del registro

        Usuario::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'rol' => 'organizador',
            'estado' => 'activo'
        ]); // guarda usuario activo con password encriptada

        return redirect()->route('login')->with('success', 'Usuario registrado correctamente');
    }

    public function autenticar(Request $request)
    {
        //dd($request->all());

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]); // valida email y password antes de autenticar

        $usuario = Usuario::where('email', $request->email)->where('estado', 'activo')->first(); // busca usuario activo por email

        //dd($usuario);

        if (!$usuario) {
            return back()->with('error', 'Usuario o contraseña incorrecta'); // usuario no existe o esta deshabilitado
        }

        if (!Hash::check($request->password, $usuario->password)) {
            return back()->with('error', 'Usuario o contraseña incorrecta'); // valida clave sin dar pistas de si el email existe
        }

        session([
            'id_usuario' => $usuario->id_usuario,
            'nombre_usuario' => $usuario->nombre,
            'rol_usuario' => $usuario->rol
        ]); // guarda session para controlar acceso a rutas protegidas
        //dd(Hash::check($request->password, $usuario->password));
        return redirect()->route('babyshowers.index');
    }

    public function logout()
    {
        session()->flush(); // limpia toda la sesion para cerrar sesion del usuario

        return redirect()->route('home')
            ->with('success', 'Sesión cerrada correctamente');
    }





    public function mostrarRecuperarPassword()
    {
        return view('auth.forgot-password');
    }

    public function enviarCorreoRecuperacion(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $usuario = Usuario::where('email', $request->email)
            ->where('estado', 'activo')
            ->first();

        if (!$usuario) {

            return back()->with(
                'error',
                'No existe un usuario activo con ese correo.'
            );
        }

        $token = Str::random(60);

        DB::table('password_resets')
            ->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $token,
                    'created_at' => now()
                ]
            );

        $url = route('password.nueva', $token);

        Mail::raw(
            "Hola {$usuario->nombre}, para recuperar tu contraseña ingresa aquí: {$url}",
            function ($message) use ($usuario) {

                $message->to($usuario->email)
                    ->subject('Recuperacion de contraseña');
            }
        );

        return back()->with(
            'success',
            'Se envió un correo de recuperacion.'
        );
    }

    public function mostrarNuevaPassword(string $token)
    {
        $registro = DB::table('password_resets')
            ->where('token', $token)
            ->first();

        if (!$registro) {

            return redirect()
                ->route('login')
                ->with('error', 'El enlace no es valido.');
        }

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $registro->email
        ]);
    }

    public function guardarNuevaPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $registro = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$registro) {

            return redirect()
                ->route('login')
                ->with('error', 'El enlace no es válido.');
        }

        Usuario::where('email', $request->email)
            ->update([
                'password' => Hash::make($request->password)
            ]);

        DB::table('password_resets')
            ->where('email', $request->email)
            ->delete();

        return redirect()
            ->route('login')
            ->with(
                'success',
                'Contraseña actualizada correctamente.'
            );
    }
}
