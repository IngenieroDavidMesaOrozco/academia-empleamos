<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Academia Corporativa')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('css/app-dashboard.css') }}">

    @yield('head')
</head>

<body>

<div class="wrapper">

    <!-- Sidebar -->
    <aside class="sidebar">

        <div class="sidebar-header">
            <div class="logo-circle">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>

            <div>
                <h5 class="mb-0 text-white">ACADEMIA</h5>
                <small class="text-light">Empleamos</small>
            </div>
        </div>

        <nav class="sidebar-nav mt-4">

            @if(auth()->check() && (auth()->user()->hasRole('SuperAdmin') || auth()->user()->hasRole('Admin')))

                <a href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-gauge"></i>
                    Dashboard
                </a>

                <a href="{{ route('usuarios.index') }}">
                    <i class="fa-solid fa-users"></i>
                    Usuarios
                </a>

                <a href="{{ route('areas.index') }}">
                    <i class="fa-solid fa-building"></i>
                    Áreas
                </a>

                <a href="{{ route('cursos.index') }}">
                    <i class="fa-solid fa-book-open"></i>
                    Cursos
                </a>

                <a href="{{ route('modulos.index') }}">
                    <i class="fa-solid fa-layer-group"></i>
                    Módulos
                </a>

                <a href="{{ route('lecciones.index') }}">
                    <i class="fa-solid fa-file-lines"></i>
                    Lecciones
                </a>

                <a href="{{ route('evaluaciones.index') }}">
                    <i class="fa-solid fa-clipboard-check"></i>
                    Evaluaciones
                </a>

                <a href="{{ route('preguntas.index') }}">
                    <i class="fa-solid fa-circle-question"></i>
                    Preguntas
                </a>

                <a href="{{ route('recursos.index') }}">
                    <i class="fa-solid fa-paperclip"></i>
                    Recursos
                </a>

            @else

                <a href="{{ route('estudiante.dashboard') }}">
                    <i class="fa-solid fa-house"></i>
                    Mis cursos
                </a>

            @endif

        </nav>
    </aside>

    <!-- Contenido -->
    <div class="main-content">

        <!-- Topbar -->
        <header class="topbar">

            <div>
                <h5 class="mb-0">@yield('page-title', 'Panel')</h5>
            </div>

            @auth
            <div class="dropdown">
                <a class="d-flex align-items-center text-decoration-none dropdown-toggle text-dark"
                   href="#"
                   data-bs-toggle="dropdown">

                    <div class="avatar me-2">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>

                    <div class="text-start">
                        <div class="fw-semibold">{{ auth()->user()->name }}</div>
                        <small class="text-muted">
                            {{ auth()->user()->roles->pluck('name')->implode(', ') }}
                        </small>
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fa-solid fa-user me-2"></i>Perfil
                        </a>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>Cerrar sesión
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
            @endauth

        </header>

        <main class="content-area">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')

</body>
</html>