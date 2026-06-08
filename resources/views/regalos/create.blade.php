@extends('layouts.app')

@section('content')

<div class="mb-4">
    <h1 class="mb-1">
        Agregar regalo
    </h1>

    <p class="text-muted mb-0">
        Evento: {{ $babyshower->titulo }}
    </p>
</div>

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">

        <div class="card shadow-sm rounded-4">
            <div class="card-body p-4">

                <form method="POST"
                      action="{{ route('babyshowers.regalos.store', $babyshower->id_babyshower) }}"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="row g-3">

                        <div class="col-12 col-md-8">
                            <label class="form-label d-flex align-items-center gap-2">
                                <i class="bi bi-gift-fill text-primary"></i> Nombre del regalo
                            </label>

                            <input
                                type="text"
                                name="nombre"
                                class="form-control"
                                placeholder="Ej: Pañales, ropa, mamadera"
                                required
                            >
                        </div>

                        <div class="col-12 col-md-4">
                            <label class="form-label d-flex align-items-center gap-2">
                                <i class="bi bi-123 text-primary"></i> Cantidad sugerida
                            </label>

                            <input
                                type="number"
                                name="cantidad_sugerida"
                                class="form-control"
                                value="1"
                                min="1"
                                required
                            >
                        </div>

                        <div class="col-12">
                            <label class="form-label d-flex align-items-center gap-2">
                                <i class="bi bi-text-paragraph text-primary"></i> Descripción
                            </label>

                            <textarea
                                name="descripcion"
                                class="form-control"
                                rows="4"
                                maxlength="300"
                                style="resize: none;"
                                placeholder="Descripción breve del regalo"
                            ></textarea>

                            <small class="text-muted">
                                Máximo 300 caracteres.
                            </small>
                        </div>

                        <div class="col-12">
                            <label class="form-label d-flex align-items-center gap-2">
                                <i class="bi bi-image-fill text-primary"></i> Imagen del regalo
                            </label>

                            <input
                                type="file"
                                name="imagen_regalo"
                                class="form-control"
                                accept="image/*"
                            >

                            <small class="text-muted">
                                Imagen opcional del regalo recomendado.
                            </small>
                        </div>

                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">

                        <a href="{{ route('babyshowers.show', $babyshower->id_babyshower) }}"
                           class="btn btn-outline-primary">
                            Volver
                        </a>

                        <button type="submit" class="btn btn-primary">
                            Guardar regalo
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection