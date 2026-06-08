@extends('layouts.app')

@section('content')
    <div class="row justify-content-center align-items-center" style="min-height: 70vh;">
        <div class="col-12 col-md-6 col-lg-5 col-xl-4">

            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4">

                    <h1 class="h4 text-center mb-3">Recuperar contraseña</h1>

                    <p class="text-muted text-center mb-4">
                        Ingresa tu correo y te enviaremos un enlace para crear una nueva contraseña.
                    </p>

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.enviar') }}">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Correo electrónico</label>
                            <input type="email" name="email" class="form-control" placeholder="correo@ejemplo.com"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            Enviar enlace
                        </button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            Volver al login
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
