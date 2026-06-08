@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7">

            <div class="mb-4">
                <h1 class="fw-bold text-body mb-1 h2">Editar Baby Shower</h1>
                <p class="text-muted mb-0">
                    Modifica los datos que necesites corregir o actualizar del evento.
                </p>
            </div>

            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4 p-sm-5">

                    <form method="POST" 
                          action="{{ route('babyshowers.update', $babyshower->id_babyshower) }}" 
                          enctype="multipart/form-data">
                        
                        @csrf
                        @method('PUT')

                        <div class="row g-4">

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-pencil-square me-1 icon-form-celeste"></i> Título del Evento
                                </label>
                                <input type="text" name="titulo" class="form-control" 
                                    value="{{ $babyshower->titulo }}" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-calendar-heart me-1 icon-form-rosa"></i> Fecha y Hora
                                </label>
                                <input type="datetime-local" name="fecha_evento" class="form-control" 
                                    value="{{ date('Y-m-d\TH:i', strtotime($babyshower->fecha_evento)) }}" required>
                                <div class="form-text text-muted mt-1" style="font-size: 0.78rem;">
                                    Ajusta el día u horario si hubo alguna modificación en la planificación.
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-geo-alt-fill me-1 icon-form-rosa"></i> Lugar / Dirección
                                </label>
                                <input type="text" name="lugar" class="form-control"
                                    value="{{ $babyshower->lugar }}" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-image me-1 icon-form-celeste"></i> Imagen de Portada
                                </label>

                                @if (!empty($babyshower->imagen_evento))
                                    <div class="mb-3 p-2 bg-body-tertiary rounded-4 d-inline-block border border-translucent">
                                        <small class="text-muted d-block mb-2 fw-semibold ps-1"><i class="bi bi-eye"></i> Imagen actual cargada:</small>
                                        <img src="{{ asset('storage/' . $babyshower->imagen_evento) }}" 
                                             class="img-fluid rounded-3 shadow-sm img-preview-edit" 
                                             alt="Imagen del evento">
                                    </div>
                                @endif

                                <input type="file" name="imagen_evento" class="form-control" accept="image/*">
                                <div class="form-text text-muted mt-1" style="font-size: 0.78rem;">
                                    Sube un archivo nuevo solo si deseas sustituir de forma permanente la imagen de arriba.
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-chat-left-text-fill text-muted me-1"></i> Dedicatoria o Descripción breve
                                </label>
                                <textarea name="descripcion" class="form-control textarea-no-resize" rows="4" maxlength="300"
                                    placeholder="Indicaciones adicionales para tus invitados...">{{ $babyshower->descripcion }}</textarea>
                                <div class="d-flex justify-content-between form-text text-muted mt-1" style="font-size: 0.78rem;">
                                    <span>Máximo 300 caracteres permitidos.</span>
                                    <span>{{ strlen($babyshower->descripcion) }} / 300</span>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top border-translucent">
                            <a href="{{ route('babyshowers.index') }}" class="btn btn-outline-secondary px-4 rounded-3 fw-semibold">
                                Cancelar
                            </a>

                            <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold shadow-sm">
                                <i class="bi bi-arrow-clockwise-fill me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection