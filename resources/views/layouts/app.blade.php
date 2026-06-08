<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MiBabyShower</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <link href="{{ asset('css/estilos.css') }}" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100">

    @include('partials.navbar')

    <main class="container mt-4 flex-grow-1">
        @yield('content')
    </main>

    @include('partials.footer')

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const htmlElement = document.documentElement; 
        const themeBtn = document.getElementById('btn-theme-toggle');
        const themeIcon = document.getElementById('theme-icon');

        // 1. Revisa si el usuario ya tenía guardada una preferencia anterior
        const savedTheme = localStorage.getItem('theme') || 'light';
        
        // Aplica el tema guardado al cargar la página
        htmlElement.setAttribute('data-bs-theme', savedTheme);
        actualizarIcono(savedTheme);

        // 2. Escucha el clic en el botón para alternar el tema
        themeBtn.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            
            
            htmlElement.setAttribute('data-bs-theme', newTheme);
            
            localStorage.setItem('theme', newTheme);
            
            actualizarIcono(newTheme);
        });

        // Función auxiliar para cambiar la luna por el sol
        function actualizarIcono(theme) {
            if (theme === 'dark') {
                themeIcon.className = 'bi bi-sun-fill text-warning fs-5';
            } else {
                themeIcon.className = 'bi bi-moon-stars-fill text-secondary fs-5';
            }
        }
    });
</script>
</body>

</html>
