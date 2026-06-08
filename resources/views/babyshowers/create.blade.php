@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-7">

            <div class="mb-4">
                <h1 class="fw-bold text-body mb-1 h2">Crear Baby Shower</h1>
                <p class="text-muted mb-0">
                    Completa la información principal para dar vida al nuevo evento.
                </p>
            </div>

            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-4 fw-semibold mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif

            <div class="card shadow-sm rounded-4">
                <div class="card-body p-4 p-sm-5">

                    <form method="POST" action="{{ route('babyshowers.store') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row g-4">

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-pencil-square me-1 icon-form-celeste"></i> Título del Evento
                                </label>
                                <input type="text" name="titulo" class="form-control" 
                                    placeholder="Ej: Baby Shower de Alfredito" required>
                            </div>

                            <div class="col-12 col-md-6">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-calendar-heart me-1 icon-form-rosa"></i> Fecha y Hora
                                </label>
                                <input type="datetime-local" name="fecha_evento" class="form-control" required>
                                <div class="form-text text-muted mt-1" style="font-size: 0.78rem;">
                                    Selecciona el día y luego define el horario de inicio.
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-geo-alt-fill me-1 icon-form-rosa"></i> Lugar / Dirección
                                </label>
                                <input type="text" name="lugar" class="form-control"
                                    placeholder="Ej: Calle Falsita #1234, Las Condes" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-image me-1 icon-form-celeste"></i> Portada o Imagen Ilustrativa
                                </label>
                                <input type="file" name="imagen_evento" class="form-control" accept="image/*">
                                <div class="form-text text-muted mt-1" style="font-size: 0.78rem;">
                                    Formatos permitidos: JPG, PNG o WEBP. Se mostrará como fondo o miniatura del evento.
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold text-body mb-2">
                                    <i class="bi bi-chat-left-text-fill text-muted me-1"></i> Dedicatoria o Descripción breve
                                </label>
                                
                                <textarea name="descripcion" class="form-control textarea-no-resize" rows="4" maxlength="300"
                                    placeholder="Escribe un mensaje de bienvenida o indicaciones adicionales para tus invitados..."></textarea>
                                <div class="d-flex justify-content-between form-text text-muted mt-1" style="font-size: 0.78rem;">
                                    <span>Cuéntales de qué se trata la celebración.</span>
                                    <span>Máx. 300 caract.</span>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-5 pt-3 border-top border-translucent">
                            <a href="{{ route('babyshowers.index') }}" class="btn btn-outline-secondary px-4 rounded-3 fw-semibold">
                                Cancelar
                            </a>

                            <button type="submit" class="btn btn-primary px-4 rounded-3 fw-semibold shadow-sm">
                                <i class="bi bi-cloud-arrow-up-fill me-1"></i> Crear Evento
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection