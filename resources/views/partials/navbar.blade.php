<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container">

        <a class="navbar-brand brand" href="{{ session('id_usuario') ? route('babyshowers.index') : url('/') }}">
            MiBabyShower
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ session('id_usuario') ? route('babyshowers.index') : url('/') }}">
                        Inicio
                    </a>
                </li>

                @if (session('id_usuario'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('babyshowers.index') }}">
                            Mis Baby Showers
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('babyshowers.create') }}">
                            Crear Evento
                        </a>
                    </li>
                @endif
            </ul>

            <ul class="navbar-nav ms-auto align-items-center flex-row justify-content-end gap-2 gap-lg-0">

                <li class="nav-item me-2 d-flex align-items-center">
                    <button id="btn-theme-toggle" class="btn btn-link nav-link p-1 text-secondary border-0 bg-transparent" type="button" aria-label="Cambiar modo de color">
                        <i id="theme-icon" class="bi bi-moon-stars-fill fs-5"></i>
                    </button>
                </li>

                @if (!session('id_usuario'))
                    <li class="nav-item me-2">
                        <a class="btn btn-outline-primary" href="{{ route('login') }}">
                            Iniciar sesión
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-primary" href="{{ route('register') }}">
                            Registrarse
                        </a>
                    </li>
                @else
                    <li class="nav-item me-2 d-flex align-items-center d-none d-sm-block">
                        <span class="text-muted small">
                            Sesión iniciada
                        </span>
                    </li>

                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                Cerrar sesión
                            </button>
                        </form>
                    </li>
                @endif

            </ul>

        </div>
    </div>
</nav>