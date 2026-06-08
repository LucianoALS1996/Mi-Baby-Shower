@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-lg-9">

            <div class="card shadow-sm rounded-4 mb-4">
                <div class="card-body p-4 text-center">

                    @if (!empty($invitado->babyshower->imagen_evento))
                        <img src="{{ asset('storage/' . $invitado->babyshower->imagen_evento) }}"
                            class="img-fluid rounded-4 border mb-4 shadow-sm" style="max-height: 280px;" alt="Imagen del evento">
                    @endif

                    <h1 class="mb-2 fw-bold text-body">
                        {{ $invitado->babyshower->titulo }}
                    </h1>

                    <p class="text-muted mb-3 fw-semibold">
                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($invitado->babyshower->fecha_evento)->format('d/m/Y H:i') }}
                        <span class="mx-2">·</span>
                        <i class="bi bi-geo-alt me-1"></i> {{ $invitado->babyshower->lugar }}
                    </p>

                    @if ($invitado->babyshower->descripcion)
                        <p class="mb-0 text-muted border-top pt-3 mt-2">
                            {{ $invitado->babyshower->descripcion }}
                        </p>
                    @endif

                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm rounded-3 fw-semibold mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                </div>
            @endif


            @if ($invitado->estado_asistencia === 'pendiente')
                <div class="card shadow-sm rounded-4 border-primary border-opacity-25 mb-4">
                    <div class="card-body p-4 text-center">

                        <h2 class="mb-3 fw-bold text-body">
                            ¡Hola {{ $invitado->nombre }}! Estás invitado/a al evento.
                        </h2>

                        <p class="text-muted mb-4 fs-5">
                            Por favor confirma si podrás asistir al baby shower.
                        </p>

                        <div class="d-flex flex-column flex-md-row justify-content-center gap-2">

                            <form method="POST" action="{{ route('invitacion.confirmar', $invitado->token_invitacion) }}">
                                @csrf
                                <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm w-100">
                                    <i class="bi bi-check-lg me-1"></i> Confirmar asistencia
                                </button>
                            </form>

                            <form method="POST" action="{{ route('invitacion.rechazar', $invitado->token_invitacion) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-secondary px-4 py-2 fw-semibold w-100">
                                    <i class="bi bi-x-lg me-1"></i> No podré asistir
                                </button>
                            </form>

                        </div>

                    </div>
                </div>
            @endif


            @if ($invitado->estado_asistencia === 'confirmado')

                <div class="card shadow-sm rounded-4 mb-4 bg-success-subtle bg-opacity-10 border border-success border-opacity-10">
                    <div class="card-body p-4">

                        <div class="d-flex justify-content-between align-items-center gap-3 flex-column flex-md-row">

                            <div>
                                <h2 class="mb-1 fw-bold text-success-emphasis fs-4">
                                    ¡Gracias por confirmar, {{ $invitado->nombre }}!
                                </h2>

                                <p class="text-muted small mb-0 fw-semibold">
                                    Puedes reservar un regalo sugerido de la lista o llevar uno por tu cuenta si lo prefieres.
                                </p>
                            </div>

                            <form method="POST" action="{{ route('invitacion.rechazar', $invitado->token_invitacion) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm fw-semibold px-3">
                                    <i class="bi bi-exclamation-triangle me-1"></i> Cambiar a: No podré asistir
                                </button>
                            </form>

                        </div>

                    </div>
                </div>


                <h3 class="mb-3 fw-bold text-body fs-4">
                    <i class="bi bi-gift me-2 text-primary"></i> Regalos sugeridos
                </h3>

                @foreach ($invitado->babyshower->regalos->where('estado', 'activo') as $regalo)
                    @php
                        $disponibles = $regalo->cantidad_sugerida - $regalo->cantidad_reservada;

                        $reservaExistente = $invitado->reservas
                            ->where('id_regalo', $regalo->id_regalo)
                            ->where('estado', 'activo')
                            ->where('estado_reserva', 'confirmada')
                            ->first();
                    @endphp

                    <div class="card shadow-sm rounded-4 mb-3">
                        <div class="card-body p-4">

                            <div class="row g-3 align-items-center">

                                <div class="col-12 col-md-2 text-center text-md-start">
                                    @if (!empty($regalo->imagen_regalo))
                                        <img src="{{ asset('storage/' . $regalo->imagen_regalo) }}"
                                            class="img-fluid rounded-4 border shadow-sm" alt="Imagen regalo">
                                    @else
                                        <div class="border border-translucent rounded-4 bg-body-secondary text-muted d-flex align-items-center justify-content-center small fw-semibold"
                                            style="height: 90px;">
                                            Sin imagen
                                        </div>
                                    @endif
                                </div>

                                <div class="col-12 col-md-6">
                                    <h4 class="mb-1 fw-bold text-body fs-5">
                                        {{ $regalo->nombre }}
                                    </h4>

                                    @if ($regalo->descripcion)
                                        <p class="text-muted small mb-2">
                                            {{ $regalo->descripcion }}
                                        </p>
                                    @endif

                                    @if ($reservaExistente)
                                        <span class="badge text-success bg-success-subtle border border-success-subtle px-2 py-1 fw-bold">
                                            <i class="bi bi-bookmark-heart-fill me-1"></i> Ya reservaste este regalo
                                        </span>
                                    @elseif ($disponibles > 0)
                                        <span class="badge text-primary bg-primary-subtle border border-primary-subtle px-2 py-1 fw-bold">
                                            {{ $disponibles }} disponibles
                                        </span>
                                    @else
                                        <span class="badge text-secondary bg-secondary-subtle border border-secondary-subtle px-2 py-1 fw-bold">
                                            Regalo completamente reservado
                                        </span>
                                    @endif
                                </div>

                                <div class="col-12 col-md-4">
                                    @if ($reservaExistente)
                                        <p class="small text-muted mb-2 text-md-center fw-semibold text-body">
                                            Cantidad reservada:
                                            <span class="badge bg-body-secondary text-body px-2 py-1 border font-monospace">{{ $reservaExistente->cantidad }}</span>
                                        </p>

                                        <form method="POST"
                                            action="{{ route('invitacion.revertirReserva', [$invitado->token_invitacion, $reservaExistente->id_reserva]) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-danger w-100 fw-semibold">
                                                <i class="bi bi-arrow-counterclockwise me-1"></i> Revertir reserva
                                            </button>
                                        </form>
                                    @else
                                        @if ($disponibles > 0)
                                            <form method="POST"
                                                action="{{ route('invitacion.reservarRegalo', [$invitado->token_invitacion, $regalo->id_regalo]) }}">
                                                @csrf

                                                <div class="mb-2">
                                                    <label class="form-label small fw-semibold text-body mb-1">
                                                        Cantidad a obsequiar:
                                                    </label>
                                                    <input type="number" name="cantidad" class="form-control"
                                                        value="1" min="1" max="{{ $disponibles }}" required>
                                                </div>

                                                <button type="submit" class="btn btn-primary w-100 fw-semibold shadow-sm">
                                                    <i class="bi bi-gift-fill me-1"></i> Reservar regalo
                                                </button>
                                            </form>
                                        @else
                                            <button class="btn btn-outline-secondary w-100 fw-semibold" disabled>
                                                <i class="bi bi-dash-circle me-1"></i> No disponible
                                            </button>
                                        @endif
                                    @endif
                                </div>

                            </div>

                        </div>
                    </div>
                @endforeach


                
                <div class="card shadow-sm rounded-4 mb-4">
                    <div class="card-body p-4 text-center text-md-start">
                        <h3 class="mb-2 fw-bold text-body fs-5">
                            ¿Prefieres llevar un regalo diferente?
                        </h3>
                        <p class="text-muted mb-0 small fw-semibold">
                            Si no encuentras algo de tu agrado en la lista, siéntete libre de asistir con un obsequio de tu propia elección.
                        </p>
                    </div>
                </div>


                <div class="card shadow-sm rounded-4 border border-primary border-opacity-10">
                    <div class="card-body p-4">

                        <h3 class="mb-3 fw-bold text-body fs-5">
                            <i class="bi bi-cart-check me-2 text-success"></i> Estoy llevando como regalo:
                        </h3>

                        @php
                            $reservasActivas = $invitado->reservas
                                ->where('estado', 'activo')
                                ->where('estado_reserva', 'confirmada');
                        @endphp

                        @if ($reservasActivas->count() > 0)
                            <div class="list-group rounded-3 shadow-sm border border-translucent">
                                @foreach ($reservasActivas as $reserva)
                                    <div class="list-group-item bg-body-tertiary text-body d-flex justify-content-between align-items-center border-translucent px-3 py-2">
                                        <span class="fw-semibold">
                                            {{ $reserva->regalo->nombre ?? 'Regalo no disponible' }}
                                        </span>
                                        <span class="badge text-primary bg-primary-subtle border border-primary-subtle fw-bold rounded-pill">
                                            Cantidad: {{ $reserva->cantidad }}
                                        </span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-3 bg-body-secondary rounded-3 text-center text-muted small fw-semibold">
                                <i class="bi bi-info-circle me-1"></i> Aún no has seleccionado regalos de la lista sugerida.
                            </div>
                        @endif

                    </div>
                </div>

            @endif


            @if ($invitado->estado_asistencia === 'cancelada')
                <div class="card shadow-sm rounded-4 border-danger border-opacity-25">
                    <div class="card-body p-4 text-center">

                        <h2 class="mb-3 fw-bold text-body">
                            Has indicado que no podrás asistir.
                        </h2>

                        <p class="text-muted mb-4 fs-5">
                            Si cambias de opinión o tus planes cambian, puedes confirmar tu asistencia en cualquier momento antes del evento.
                        </p>

                        <form method="POST" action="{{ route('invitacion.confirmar', $invitado->token_invitacion) }}">
                            @csrf
                            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold shadow-sm">
                                <i class="bi bi-check-lg me-1"></i> Cambiar y Confirmar asistencia
                            </button>
                        </form>

                    </div>
                </div>
            @endif

        </div>
    </div>

    <div class="text-center mt-4">
        <a href="/" class="btn btn-outline-secondary fw-semibold px-4 rounded-3 shadow-sm">
            <i class="bi bi-box-arrow-right me-1"></i> Salir de la invitación
        </a>
    </div>

@endsection