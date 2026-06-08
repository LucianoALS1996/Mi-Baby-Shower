@extends('layouts.app')

@section('content')

<div class="row justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="col-12 col-md-6 col-lg-5 col-xl-4">

        <div class="card shadow-sm rounded-4">
            <div class="card-body p-4">

                <h1 class="h4 text-center mb-3">Crear nueva contraseña</h1>

                <p class="text-muted text-center mb-4">
                    Ingresa tu nueva contraseña para recuperar el acceso.
                </p>

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.guardar') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ $email }}">

                    <div class="mb-3">
                        <label class="form-label">Nueva contraseña</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="Nueva contraseña"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirmar contraseña</label>
                        <input
                            type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Repite la contraseña"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Actualizar contraseña
                    </button>
                </form>

            </div>
        </div>

    </div>
</div>

@endsection
