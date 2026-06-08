@extends('layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-12 col-md-6 col-lg-5 col-xl-4">

            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <i class="bi bi-balloon-heart-fill fs-1 text-primary"></i>
                        <h1 class="h3 mt-2 mb-1">Iniciar sesión</h1>
                        <p class="text-muted mb-0">
                            Accede para administrar tus eventos.
                        </p>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.autenticar') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" placeholder="Ingresa tu contraseña"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Ingresar
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <span class="text-muted">¿No tienes cuenta?</span>
                        <a href="{{ route('register') }}" class="text-decoration-none">
                            Registrarse
                        </a>
                    </div>
                    <div class="text-center mt-2">
                        <a href="{{ route('password.recuperar') }}" class="text-decoration-none">
                            ¿Olvidaste tu contraseña?
                        </a>
                    </div>



                </div>
            </div>

        </div>
    </div>
@endsection
