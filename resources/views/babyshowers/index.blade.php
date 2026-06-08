@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4 mt-2">
        <div>
            <h1 class="fw-bold text-body mb-1">Mis Baby Showers</h1>
            <p class="text-muted mb-0">Administra tus eventos, lista de invitados y control de regalos.</p>
        </div>
        <a href="{{ route('babyshowers.create') }}" class="btn btn-primary d-inline-flex align-items-center gap-2">
            <i class="bi bi-plus-circle-fill"></i> Crear Nuevo Evento
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3 mb-4 fw-semibold" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        @forelse ($babyshowers as $babyshower)
            <div class="col-12 col-md-6 col-xl-4 mb-4">
                <div class="card shadow-sm h-100 d-flex flex-column justify-content-between">
                    
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h4 class="fw-bold text-body mb-0 style-title">
                                {{ $babyshower->titulo }}
                            </h4>
                            @if ($babyshower->estado === 'activo')
                                <span class="badge badge-activo">Activo</span>
                            @else
                                <span class="badge badge-inactivo">Inactivo</span>
                            @endif
                        </div>

                        <div class="d-flex flex-column gap-2 my-3 py-2">
                            <div class="event-info-item">
                                <i class="bi bi-calendar-event"></i>
                                <span>{{ \Carbon\Carbon::parse($babyshower->fecha_evento)->format('d/m/Y H:i') }} hrs</span>
                            </div>
                            <div class="event-info-item">
                                <i class="bi bi-geo-alt"></i>
                                <span>{{ $babyshower->lugar }}</span>
                            </div>
                            <div class="event-info-item">
                                <i class="bi bi-people"></i>
                                <span><strong>{{ $babyshower->invitados->count() }}</strong> invitados</span>
                            </div>
                            <div class="event-info-item">
                                <i class="bi bi-gift"></i>
                                <span><strong>{{ $babyshower->regalos->count() }}</strong> regalos en la lista</span>
                            </div>
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('babyshowers.show', $babyshower->id_babyshower) }}" class="btn btn-action-view w-100 d-flex align-items-center justify-content-center gap-2">
                                <i class="bi bi-eye-fill"></i> Gestionar Evento
                            </a>
                        </div>
                    </div>

                    <div class="card-footer-actions d-flex justify-content-between align-items-center gap-2">
                        <a href="{{ route('babyshowers.edit', $babyshower->id_babyshower) }}" class="btn btn-sm btn-light border fw-semibold rounded-3 px-3 w-50">
                            <i class="bi bi-pencil-square"></i> Editar
                        </a>

                        <form method="POST" action="{{ route('babyshowers.destroy', $babyshower->id_babyshower) }}" class="w-50">
                            @csrf
                            @method('DELETE')
                            @if ($babyshower->estado === 'activo')
                                <button type="submit" class="btn btn-sm btn-outline-danger fw-semibold rounded-3 px-2 w-100">
                                    <i class="bi bi-x-circle"></i> Finalizar
                                </button>
                            @else
                                <button type="submit" class="btn btn-sm btn-outline-success fw-semibold rounded-3 px-2 w-100">
                                    <i class="bi bi-check-lg"></i> Habilitar
                                </button>
                            @endif
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm p-5 text-center">
                    <div class="card-body py-4">
                        <div class="bg-body-tertiary p-4 rounded-circle mb-3 empty-state-circle">
                            <i class="bi bi-balloon-heart-fill display-4" style="color: var(--color-rosa-dark);"></i>
                        </div>
                        <h3 class="fw-bold text-body mt-2">No tienes eventos creados aún</h3>
                        <p class="text-muted mx-auto text-max-width-md">Comienza creando tu primer baby shower para empezar a gestionar tus invitados y la lista de regalos de manera automatizada.</p>
                        <a href="{{ route('babyshowers.create') }}" class="btn btn-primary mt-3 px-4 shadow-sm">
                            <i class="bi bi-plus-circle-fill me-2"></i>Crear Mi Primer Evento
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
@endsection