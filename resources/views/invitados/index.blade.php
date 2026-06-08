@extends('layouts.app')

@section('content')

@if (session('success'))
    <div class="alert alert-success border-0 shadow-sm rounded-3 fw-semibold">
        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger border-0 shadow-sm rounded-3 fw-semibold">
        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
    </div>
@endif

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="mb-1 fw-bold text-body">Invitados</h1>
        <p class="text-muted mb-0">
            Evento: {{ $babyshower->titulo }}
        </p>
    </div>

    <a href="{{ route('babyshowers.invitados.create', $babyshower->id_babyshower) }}"
       class="btn btn-primary d-inline-flex align-items-center gap-2 fw-semibold">
        <i class="bi bi-person-plus-fill"></i> Agregar invitado
    </a>
</div>

@forelse ($babyshower->invitados as $invitado)

    <div class="card shadow-sm rounded-4 mb-3">
        <div class="card-body p-4">

            <div class="row g-4">

                <div class="col-12 col-md-8">

                    <form method="POST"
                          action="{{ route('babyshowers.invitados.update', [$babyshower->id_babyshower, $invitado->id_invitado]) }}">

                        @csrf
                        @method('PUT')

                        <div class="d-flex align-items-center gap-2 mb-3">
                            <h5 class="mb-0 fw-bold text-body">
                                {{ $invitado->nombre }}
                            </h5>

                            @if ($invitado->estado === 'activo')
                                <span class="badge text-success bg-success-subtle border border-success-subtle px-2 py-1">
                                    Activo
                                </span>
                            @else
                                <span class="badge text-secondary bg-secondary-subtle border border-secondary-subtle px-2 py-1">
                                    Inactivo
                                </span>
                            @endif
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label fw-semibold text-body">Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="{{ $invitado->nombre }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-body">Teléfono</label>
                                <input type="text" name="telefono" class="form-control" value="{{ $invitado->telefono }}">
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-body">Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $invitado->email }}">
                            </div>
                        </div>

                        <div class="row g-3 align-items-end mt-1">
                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block mb-1 fw-semibold">Invitación</small>
                                <div class="border border-translucent rounded-3 px-3 py-2 bg-body-secondary small fw-bold text-body text-capitalize">
                                    {{ $invitado->estado_invitacion }}
                                </div>
                            </div>

                            <div class="col-6 col-md-4">
                                <small class="text-muted d-block mb-1 fw-semibold">Asistencia</small>
                                <div class="border border-translucent rounded-3 px-3 py-2 bg-body-secondary small fw-bold text-body text-capitalize">
                                    {{ $invitado->estado_asistencia }}
                                </div>
                            </div>

                            <div class="col-12 col-md-4">
                                <small class="text-muted d-block mb-1 fw-semibold">Estado</small>
                                <div class="border border-translucent rounded-3 px-3 py-2 bg-body-secondary small fw-bold text-body text-capitalize">
                                    {{ $invitado->estado }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <small class="text-muted d-block mb-1 fw-semibold">URL invitación</small>
                            <div class="border border-translucent rounded-3 px-3 py-2 bg-body-secondary small text-break fw-semibold text-body">
                                {{ url('/invitacion/' . $invitado->token_invitacion) }}
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary fw-semibold shadow-sm">
                                <i class="bi bi-download me-1"></i> Guardar cambios
                            </button>
                        </div>

                    </form>

                </div>

                <div class="col-12 col-md-4">
                    <div class="d-grid gap-2">

                        <form method="POST"
                              action="{{ route('babyshowers.invitados.enviar', [$babyshower->id_babyshower, $invitado->id_invitado]) }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-primary w-100 fw-semibold">
                                <i class="bi bi-send-fill me-1"></i> Enviar invitación
                            </button>
                        </form>

                        <form method="POST"
                              action="{{ route('babyshowers.invitados.destroy', [$babyshower->id_babyshower, $invitado->id_invitado]) }}">
                            @csrf
                            @method('DELETE')

                            @if ($invitado->estado === 'activo')
                                <button type="submit" class="btn btn-outline-danger w-100 fw-semibold">
                                    <i class="bi bi-person-x-fill me-1"></i> Deshabilitar
                                </button>
                            @else
                                <button type="submit" class="btn btn-outline-success w-100 fw-semibold">
                                    <i class="bi bi-person-check-fill me-1"></i> Habilitar
                                </button>
                            @endif
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>

@empty

    <div class="card shadow-sm rounded-4 border border-translucent">
        <div class="card-body text-center py-5">
            <div class="d-inline-flex align-items-center justify-content-center bg-body-tertiary p-4 rounded-circle mb-3" style="width: 80px; height: 80px;">
                <i class="bi bi-people text-muted fs-1"></i>
            </div>
            <h4 class="mt-2 fw-bold text-body">No hay invitados agregados</h4>
            <p class="text-muted mx-auto mb-4" style="max-width: 420px;">
                Puedes agregar invitados para enviarles de forma personalizada sus enlaces de confirmación de asistencia.
            </p>
            <a href="{{ route('babyshowers.invitados.create', $babyshower->id_babyshower) }}"
               class="btn btn-primary px-4 fw-semibold shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Agregar invitado
            </a>
        </div>
    </div>

@endforelse

<div class="mt-4">
    <a href="{{ route('babyshowers.show', $babyshower->id_babyshower) }}"
       class="btn btn-outline-secondary fw-semibold rounded-3">
        <i class="bi bi-arrow-left-short"></i> Volver al evento
    </a>
</div>

@endsection