<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthManual
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('id_usuario')) {
            return redirect()->route('login'); // revisa que el usuario haya iniciado sesion
        }

        return $next($request); // permite continuar si hay session valida
    }
}
