<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Academia Corporativa')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/app-dashboard.css') }}">

    @yield('head')

    <style>
        /* MODO OSCURO GLOBAL MEJORADO */
        [data-bs-theme="dark"] body { background-color: #121212 !important; color: #e0e0e0 !important; }
        [data-bs-theme="dark"] .sidebar { background-color: #1e1e1e !important; border-right: 1px solid #333; }
        [data-bs-theme="dark"] .sidebar-nav a { color: #d1d1d1 !important; }
        [data-bs-theme="dark"] .sidebar-nav a:hover { background-color: #333 !important; color: #fff !important; }
        [data-bs-theme="dark"] .topbar { background-color: #1e1e1e !important; border-bottom: 1px solid #333 !important; color: #ffffff !important; }
        
        /* Textos visibles en la topbar y perfil */
        [data-bs-theme="dark"] .topbar .dropdown-toggle { color: #ffffff !important; }
        [data-bs-theme="dark"] .topbar .text-muted { color: #b0b0b0 !important; }

        /* Tarjetas y Contenedores */
        [data-bs-theme="dark"] .card { background-color: #1e1e1e !important; border: 1px solid #333 !important; color: #fff !important; }
        
        /* Tablas oscuras limpias (adiós bloques blancos feos) */
        [data-bs-theme="dark"] .table { color: #e0e0e0 !important; background-color: #1e1e1e !important; border-color: #333 !important; }
        [data-bs-theme="dark"] .table th, 
        [data-bs-theme="dark"] .table td { background-color: #1e1e1e !important; color: #e0e0e0 !important; border-color: #333 !important; }
        [data-bs-theme="dark"] .table-striped > tbody > tr:nth-of-type(odd) > * { background-color: #252525 !important; color: #e0e0e0 !important; }

        /* Dropdowns y Formularios */
        [data-bs-theme="dark"] .dropdown-menu { background-color: #1e1e1e !important; border: 1px solid #444 !important; }
        [data-bs-theme="dark"] .dropdown-item { color: #e0e0e0 !important; }
        [data-bs-theme="dark"] .dropdown-item:hover { background-color: #333 !important; color: #fff !important; }
  
  /* Ajuste para que los mensajes de alerta se vean bien en modo oscuro */
        [data-bs-theme="dark"] .alert-info { 
            background-color: #2d2d2d !important; 
            border-color: #444 !important; 
            color: #e0e0e0 !important; 
        }
  
    </style>

</head>

<body>
<div class="wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header mb-4 mt-2">
            <a href="{{ route('admin.dashboard') }}" class="logo-link text-decoration-none d-flex align-items-center gap-3">
                <div class="logo-circle"><img src="{{ asset('imagenes/logoET.png') }}" alt="Empleamos" class="logo-img"></div>
                <div class="sidebar-brand-text text-white">
                    <div class="fw-bold fs-5 lh-1 mb-1">Empleamos</div>
                    <div class="text-white-50" style="font-size: 0.75rem;">Academia Corporativa</div>
                </div>
            </a>
        </div>

        <nav class="sidebar-nav mt-4">
            @if(auth()->check() && (auth()->user()->hasRole('SuperAdmin') || auth()->user()->hasRole('Admin')))
                <a href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-gauge"></i> Dashboard</a>
                <a href="{{ route('usuarios.index') }}"><i class="fa-solid fa-users"></i> Usuarios</a>
                <a href="{{ route('areas.index') }}"><i class="fa-solid fa-building"></i> Áreas</a>
                <a href="{{ route('cursos.index') }}"><i class="fa-solid fa-book-open"></i> Cursos</a>
                <a href="{{ route('recursos.index') }}"><i class="fa-solid fa-paperclip"></i> Recursos</a>
            @else
                <a href="{{ route('estudiante.dashboard') }}"><i class="fa-solid fa-house"></i> Mis cursos</a>
            @endif
        </nav>
    </aside>

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content">
        <header class="topbar d-flex justify-content-between align-items-center px-4">
            <h5 class="mb-0 fw-bold">@yield('page-title', 'Panel')</h5>
            <div class="d-flex align-items-center gap-3">
                @auth
                <div class="dropdown">
                    <a class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark" href="#" data-bs-toggle="dropdown">
                        <div class="avatar me-2">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                        <div class="text-start">
                            <div class="fw-semibold">{{ auth()->user()->name }}</div>
                            <small class="text-muted">{{ auth()->user()->roles->pluck('name')->implode(', ') }}</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">Cerrar sesión</button>
                            </form>
                        </li>
                    </ul>
                </div>
                @endauth
            </div>
        </header>

        <main class="content-area p-4">
            <div class="mb-3">
                <button onclick="window.history.back()" class="btn btn-sm btn-outline-secondary border-0 text-muted">
                    <i class="fa-solid fa-arrow-left me-1"></i> Regresar
                </button>
            </div>
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const html = document.documentElement;

        // Cargar preferencia guardada de modo oscuro
        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);

        // Controlar el clic únicamente en el botón flotante / tuerca que ya funciona abajo
        document.addEventListener('click', function(e) {
            const target = e.target.closest('button, a, i, div');
            if (!target) return;

            const isThemeButton = target.classList.contains('fa-moon') || 
                                  target.classList.contains('fa-sun') || 
                                  target.classList.contains('fa-gear');

            if (isThemeButton) {
                e.preventDefault();
                e.stopPropagation();
                
                const current = html.getAttribute('data-bs-theme');
                const next = current === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-bs-theme', next);
                localStorage.setItem('theme', next);
            }
        });
    });
</script>
</body>
</html>