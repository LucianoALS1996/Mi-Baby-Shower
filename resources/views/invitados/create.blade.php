@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h1 class="mb-1">Agregar invitado</h1>

    <p class="text-muted mb-0">
        Evento: {{ $babyshower->titulo }}
    </p>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">

        <div class="card shadow-sm rounded-4">
            <div class="card-body p-4">

                <form method="POST" action="{{ route('babyshowers.invitados.store', $babyshower->id_babyshower) }}">
                    @csrf

                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label">
                                <i class="bi bi-person-fill text-primary"></i> Nombre
                            </label>
                            <input
                                type="text"
                                name="nombre"
                                class="form-control"
                                placeholder="Nombre del invitado"
                                required
                            >
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">
                                <i class="bi bi-telephone-fill text-primary"></i> Teléfono
                            </label>
                            <input
                                type="text"
                                name="telefono"
                                class="form-control"
                                placeholder="+56 9 1234 5678"
                            >
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label">
                                <i class="bi bi-envelope-fill text-primary"></i> Email
                            </label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="correo@ejemplo.com"
                            >
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <a href="{{ route('babyshowers.show', $babyshower->id_babyshower) }}"
                           class="btn btn-outline-primary">
                            Volver
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Guardar invitado
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection
