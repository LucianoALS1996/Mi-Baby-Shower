@extends('layouts.app')

@section('content')
    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-12 col-lg-8">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <h1 class="fw-bold text-body mb-0">{{ $babyshower->titulo }}</h1>
                        @if ($babyshower->estado === 'activo')
                            <span class="badge badge-activo">Activo</span>
                        @else
                            <span class="badge badge-inactivo">Inactivo</span>
                        @endif
                    </div>

                    <p class="text-muted mb-4">
                        <i class="bi bi-person-heart text-secondary"></i> Organizado por <strong>{{ $babyshower->usuario->nombre }}</strong>
                    </p>

                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <div class="p-2 rounded-3 icon-circle-celeste">
                                    <i class="bi bi-calendar-event-fill fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block lh-1">Fecha del evento</small>
                                    <strong class="text-body">{{ \Carbon\Carbon::parse($babyshower->fecha_evento)->format('d/m/Y H:i') }} hrs</strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6">
                            <div class="d-flex align-items-center gap-2">
                                <div class="p-2 rounded-3 icon-circle-rosa">
                                    <i class="bi bi-geo-alt-fill fs-5"></i>
                                </div>
                                <div>
                                    <small class="text-muted d-block lh-1">Lugar</small>
                                    <strong class="text-body">{{ $babyshower->lugar }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($babyshower->descripcion)
                        <div class="mt-4 p-3 rounded-4 bg-body-secondary bg-opacity-50 border-start border-4 shadow-sm event-description-box">
                            <small class="text-uppercase fw-bold text-body-emphasis small d-block mb-1 event-description-title">
                                <i class="bi bi-file-text me-1"></i> Descripción
                            </small>
                            <p class="mb-0 text-body lh-base event-description-text">
                                {{ $babyshower->descripcion }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="col-12 col-lg-4 text-center mt-4 mt-lg-0">
                    @if (!empty($babyshower->imagen_evento))
                        <img src="{{ asset('storage/' . $babyshower->imagen_evento) }}" class="img-fluid rounded-4 shadow-sm border img-cover-detail" alt="Imagen evento">
                    @else
                        <div class="rounded-4 p-5 d-flex flex-column align-items-center justify-content-center bg-body-tertiary border text-center img-placeholder-detail">
                            
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-3 shadow-sm img-placeholder-icon-wrap">
                                <i class="bi bi-image fs-3 img-placeholder-icon"></i>
                            </div>
                            
                            <span class="small fw-bold text-body">Sin imagen cargada</span>
                            <span class="text-muted small text-size-sm">Aún no se ha asignado una foto al evento</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body p-4">
            <h3 class="fw-bold text-body mb-3 h5">Panel de Operaciones</h3>
            <div class="d-flex flex-wrap gap-2 align-items-center">
                
                <a href="{{ route('babyshowers.regalos.index', $babyshower->id_babyshower) }}" class="btn btn-sm btn-outline-primary px-3 py-2">
                    <i class="bi bi-gift"></i> Ver Todos los Regalos
                </a>

                <a href="{{ route('babyshowers.invitados.index', $babyshower->id_babyshower) }}" class="btn btn-sm btn-outline-primary px-3 py-2">
                    <i class="bi bi-people"></i> Ver Todos los Invitados
                </a>

                <form method="POST" action="{{ route('babyshowers.invitados.enviarMasivo', $babyshower->id_babyshower) }}"
                    onsubmit="bloquearEnvioMasivo(this)" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-primary px-3 py-2">
                        <i class="bi bi-send-fill me-1"></i> Enviar Invitaciones Masivas
                    </button>
                </form>

                @if (session('success'))
                    <span class="badge badge-activo ms-2">✔ {{ session('success') }}</span>
                @endif
                @if (session('error'))
                    <span class="badge badge-inactivo ms-2">✖ {{ session('error') }}</span>
                @endif
                <span class="small resultado-envio-masivo ms-2 fw-bold text-primary"></span>
            </div>
        </div>
    </div>

    <div class="row g-4">
        
        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold h5 text-body mb-0"><i class="bi bi-gift-fill"></i> Regalos Sugeridos</h3>
                        <a href="{{ route('babyshowers.regalos.create', $babyshower->id_babyshower) }}" class="btn btn-primary btn-sm rounded-3 px-3">
                            <i class="bi bi-plus-lg"></i> Agregar
                        </a>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @forelse ($babyshower->regalos as $regalo)
                            <div class="sub-card-item p-3">
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <div>
                                        <h5 class="fw-bold text-body h6 mb-1">{{ $regalo->nombre }}</h5>
                                        @if ($regalo->descripcion)
                                            <p class="text-muted small mb-0">{{ $regalo->descripcion }}</p>
                                        @endif
                                    </div>
                                    @if ($regalo->estado === 'activo')
                                        <span class="badge badge-activo text-size-xs px-2 py-1">Disponible</span>
                                    @else
                                        <span class="badge badge-inactivo text-size-xs px-2 py-1">No disp.</span>
                                    @endif
                                </div>

                                <div class="d-flex flex-wrap gap-2 mt-2 pt-2 border-top border-translucent text-muted justify-content-between text-size-md">
                                    <span>Sugeridos: <strong class="text-body">{{ $regalo->cantidad_sugerida }}</strong></span>
                                    <span>Reservados: <strong class="text-primary">{{ $regalo->cantidad_reservada }}</strong></span>
                                    <span>Libres: <strong class="text-success">{{ $regalo->cantidad_sugerida - $regalo->cantidad_reservada }}</strong></span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-gift sub-card-empty-icon display-6 mb-2 d-block"></i>
                                <p class="small mb-0">No hay regalos en esta lista aún.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-6">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fw-bold h5 text-body mb-0"><i class="bi bi-people-fill"></i> Lista de Invitados</h3>
                        <a href="{{ route('babyshowers.invitados.create', $babyshower->id_babyshower) }}" class="btn btn-primary btn-sm rounded-3 px-3">
                            <i class="bi bi-plus-lg"></i> Agregar
                        </a>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        @forelse ($babyshower->invitados as $invitado)
                            <div class="sub-card-item p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h5 class="fw-bold text-body h6 mb-1">{{ $invitado->nombre }}</h5>
                                        <div class="text-muted text-size-md">
                                            @if ($invitado->telefono)
                                                <span class="me-2"><i class="bi bi-telephone"></i> {{ $invitado->telefono }}</span>
                                            @endif
                                            @if ($invitado->email)
                                                <span><i class="bi bi-envelope"></i> {{ $invitado->email }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($invitado->estado === 'activo')
                                        <span class="badge badge-activo text-size-xs px-2 py-1">Activo</span>
                                    @else
                                        <span class="badge badge-inactivo text-size-xs px-2 py-1">Inactivo</span>
                                    @endif
                                </div>

                                <div class="d-flex gap-2 mb-2">
                                    <span class="badge-info-custom">✉ {{ $invitado->estado_invitacion }}</span>
                                    <span class="badge-info-custom">👍 {{ $invitado->estado_asistencia }}</span>
                                </div>

                                <div class="mt-2 pt-2 border-top border-translucent">
                                    <label class="form-label text-muted mb-1 label-url-readonly">Link de Acceso Invitado</label>
                                    <input type="text" value="{{ url('/invitacion/' . $invitado->token_invitacion) }}"
                                        class="form-control form-control-sm input-url-readonly" readonly>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="bi bi-people sub-card-empty-icon display-6 mb-2 d-block"></i>
                                <p class="small mb-0">No hay amigos agregados a la lista.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="mt-4 mb-2">
        <a href="{{ route('babyshowers.index') }}" class="btn btn-outline-secondary px-4">
            <i class="bi bi-arrow-left"></i> Volver a Mis Eventos
        </a>
    </div>

    <script>
    function bloquearEnvioMasivo(form) {
        const boton = form.querySelector('button[type="submit"]');
        boton.disabled = true;
        
        
        boton.classList.add('btn-sending-state');
        boton.innerHTML = '<i class="bi bi-hourglass-split"></i> Enviando correos...';
    }
    </script>
@endsection