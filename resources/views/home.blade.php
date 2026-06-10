@extends('layouts.app')

@section('content')
    <div class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7 text-center text-lg-start">
                    <h1 class="display-5 fw-bold text-body">Organiza tu baby shower perfecto</h1>
                    <p class="lead text-muted">Gestiona invitados, regalos e invitaciones de manera sencilla y elegante.</p>
                    <p class="mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2 fw-semibold shadow-sm">
                            <i class="bi bi-person-plus-fill me-1"></i> Crear cuenta
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-1"></i> Iniciar sesión
                        </a>
                    </p>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center">
                    <div class="baby-hero-art">
                        <i class="bi bi-balloon-heart-fill"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row g-4">
            
            <div class="col-md-4">
                <div class="card h-100 shadow-sm border border-translucent rounded-4">
                    <div class="card-body text-center p-4">
                        <div class="bg-body-secondary p-3 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary shadow-sm" style="width: 70px; height: 70px;">
                            <i class="bi bi-people-fill fs-2"></i>
                        </div>
                        <h5 class="card-title fw-bold text-body fs-5">Invitados</h5>
                        <p class="card-text text-muted small">Invita, confirma y organiza a tus asistentes con facilidad.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border border-translucent rounded-4">
                    <div class="card-body text-center p-4">
                        <div class="bg-body-secondary p-3 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary shadow-sm" style="width: 70px; height: 70px;">
                            <i class="bi bi-gift-fill fs-2"></i>
                        </div>
                        <h5 class="card-title fw-bold text-body fs-5">Regalos</h5>
                        <p class="card-text text-muted small">Administra tu lista de regalos y evita que se dupliquen.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 shadow-sm border border-translucent rounded-4">
                    <div class="card-body text-center p-4">
                        <div class="bg-body-secondary p-3 rounded-circle d-inline-flex align-items-center justify-content-center mb-3 text-primary shadow-sm" style="width: 70px; height: 70px;">
                            <i class="bi bi-envelope-paper-heart-fill fs-2"></i>
                        </div>
                        <h5 class="card-title fw-bold text-body fs-5">Invitaciones</h5>
                        <p class="card-text text-muted small">Crea y envía invitaciones  a través de emails.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
