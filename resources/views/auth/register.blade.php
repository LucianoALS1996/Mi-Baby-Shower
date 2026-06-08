@extends('layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-12 col-md-7 col-lg-5 col-xl-4">

            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">

                    <div class="text-center mb-4">
                        <i class="bi bi-person-plus fs-1 text-primary"></i>

                        <h1 class="h3 mt-2 mb-1">
                            Registrarse
                        </h1>

                        <p class="text-muted mb-0">
                            Crea una cuenta para administrar tus eventos.
                        </p>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">
                                Nombre
                            </label>

                            <input type="text" name="nombre" class="form-control" placeholder="Ingresa tu nombre"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Correo electrónico
                            </label>

                            <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Contraseña
                            </label>

                            <input type="password" name="password" class="form-control" placeholder="Crea una contraseña"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">
                                Confirmar contraseña
                            </label>

                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Repite tu contraseña" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Registrarse
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <span class="text-muted">
                            ¿Ya tienes cuenta?
                        </span>

                        <a href="{{ route('login') }}" class="text-decoration-none">
                            Iniciar sesión
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
