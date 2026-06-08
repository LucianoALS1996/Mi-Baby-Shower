@extends('layouts.app')

@section('content')
    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 fw-semibold">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1 fw-bold text-body">Regalos</h1>
            <p class="text-muted mb-0">
                Evento: {{ $babyshower->titulo }}
            </p>
        </div>

        <a href="{{ route('babyshowers.regalos.create', $babyshower->id_babyshower) }}" class="btn btn-primary d-inline-flex align-items-center gap-2 fw-semibold">
            <i class="bi bi-plus-circle-fill"></i> Agregar regalo
        </a>
    </div>

    @forelse ($babyshower->regalos as $regalo)
        <div class="card shadow-sm rounded-4 mb-3">
            <div class="card-body p-4">

                <form method="POST"
                    action="{{ route('babyshowers.regalos.update', [$babyshower->id_babyshower, $regalo->id_regalo]) }}"
                    enctype="multipart/form-data">

                    @csrf
                    @method('PUT')

                    <div class="row g-3 align-items-start">

                        <div class="col-12 col-md-2">

                            @if (!empty($regalo->imagen_regalo))
                                <img src="{{ asset('storage/' . $regalo->imagen_regalo) }}"
                                    class="img-fluid rounded-4 border border-translucent mb-2" alt="Imagen regalo">
                            @else
                                <div class="border border-translucent rounded-4 bg-body-tertiary text-muted d-flex align-items-center justify-content-center mb-2 fw-semibold"
                                    style="height: 100px; font-size: 0.9rem;">
                                    <i class="bi bi-image me-1"></i> Sin imagen
                                </div>
                            @endif

                            <input type="file" name="imagen_regalo" class="form-control form-control-sm"
                                accept="image/*">

                        </div>

                        <div class="col-12 col-md-7">

                            <div class="d-flex align-items-center gap-2 mb-3">
                                <h5 class="mb-0 fw-bold text-body">
                                    {{ $regalo->nombre }}
                                </h5>

                                @if ($regalo->estado === 'activo')
                                    <span class="badge text-success bg-success-subtle border border-success-subtle px-2 py-1">Activo</span>
                                @else
                                    <span class="badge text-secondary bg-secondary-subtle border border-secondary-subtle px-2 py-1">Inactivo</span>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-body">Nombre</label>
                                <input type="text" name="nombre" class="form-control" value="{{ $regalo->nombre }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold text-body">Descripción</label>
                                <textarea name="descripcion" class="form-control" rows="3" maxlength="300" style="resize: none;">{{ $regalo->descripcion }}</textarea>
                                <small class="text-muted d-block mt-1">
                                    ¼ximo 300 caracteres.
                                </small>
                            </div>

                            <div class="row g-3 align-items-end">

                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-semibold text-body">
                                        Cantidad sugerida
                                    </label>
                                    <input type="number" name="cantidad_sugerida" class="form-control"
                                        value="{{ $regalo->cantidad_sugerida }}" min="1" required>
                                </div>

                                <div class="col-6 col-md-4">
                                    <small class="text-muted d-block mb-1 fw-semibold">
                                        Reservados
                                    </small>
                                    <div class="border border-translucent rounded-3 px-3 py-2 bg-body-secondary small fw-bold text-body">
                                        {{ $regalo->cantidad_reservada }}
                                    </div>
                                </div>

                                <div class="col-6 col-md-4">
                                    <small class="text-muted d-block mb-1 fw-semibold">
                                        Disponibles
                                    </small>
                                    <div class="border border-translucent rounded-3 px-3 py-2 bg-body-secondary small fw-bold text-body">
                                        {{ $regalo->cantidad_sugerida - $regalo->cantidad_reservada }}
                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="col-12 col-md-3">
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary fw-semibold shadow-sm">
                                    <i class="bi bi-download me-1"></i> Guardar cambios
                                </button>
                </form>

                <form method="POST"
                    action="{{ route('babyshowers.regalos.destroy', [$babyshower->id_babyshower, $regalo->id_regalo]) }}">
                    @csrf
                    @method('DELETE')

                    @if ($regalo->estado === 'activo')
                        <button type="submit" class="btn btn-outline-danger w-100 fw-semibold">
                            <i class="bi bi-eye-slash-fill me-1"></i> Deshabilitar
                        </button>
                    @else
                        <button type="submit" class="btn btn-outline-success w-100 fw-semibold">
                            <i class="bi bi-eye-fill me-1"></i> Habilitar
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
                    <i class="bi bi-gift text-muted fs-1"></i>
                </div>
                <h4 class="mt-2 fw-bold text-body">No hay regalos agregados</h4>
                <p class="text-muted mx-auto mb-4" style="max-width: 420px;">
                    Puedes agregar regalos sugeridos para que los invitados puedan reservarlos desde su invitación.
                </p>
                <a href="{{ route('babyshowers.regalos.create', $babyshower->id_babyshower) }}" class="btn btn-primary px-4 fw-semibold shadow-sm">
                    <i class="bi bi-plus-circle-fill me-1"></i> Agregar regalo
                </a>
            </div>
        </div>
    @endforelse

    <div class="mt-4">
        <a href="{{ route('babyshowers.show', $babyshower->id_babyshower) }}" class="btn btn-outline-secondary fw-semibold rounded-3">
            <i class="bi bi-arrow-left-short"></i> Volver al evento
        </a>
    </div>
@endsection