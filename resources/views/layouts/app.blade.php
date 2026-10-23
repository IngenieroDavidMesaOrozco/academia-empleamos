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
    <!-- SweetAlert2 CSS & JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/app-dashboard.css') }}">

    @yield('head')

    <style>
        /* MODO OSCURO  */
        [data-bs-theme="dark"] body { background-color: #121212 !important; color: #e0e0e0 !important; }
        [data-bs-theme="dark"] .sidebar { background-color: #1e1e1e !important; border-right: 1px solid #333; }
        [data-bs-theme="dark"] .sidebar-nav a { color: #d1d1d1 !important; }
        [data-bs-theme="dark"] .sidebar-nav a:hover { background-color: #333 !important; color: #fff !important; }
        [data-bs-theme="dark"] .topbar { background-color: #1e1e1e !important; border-bottom: 1px solid #333 !important; color: #ffffff !important; }
        
        [data-bs-theme="dark"] .topbar .dropdown-toggle { color: #ffffff !important; }
        [data-bs-theme="dark"] .topbar .text-muted { color: #b0b0b0 !important; }
        [data-bs-theme="dark"] .card { background-color: #1e1e1e !important; border: 1px solid #333 !important; color: #fff !important; }
        
        [data-bs-theme="dark"] .table { color: #e0e0e0 !important; background-color: #1e1e1e !important; border-color: #333 !important; }
        [data-bs-theme="dark"] .table th, 
        [data-bs-theme="dark"] .table td { background-color: #1e1e1e !important; color: #e0e0e0 !important; border-color: #333 !important; }
        [data-bs-theme="dark"] .table-striped > tbody > tr:nth-of-type(odd) > * { background-color: #252525 !important; color: #e0e0e0 !important; }

        [data-bs-theme="dark"] .dropdown-menu { background-color: #1e1e1e !important; border: 1px solid #444 !important; }
        [data-bs-theme="dark"] .dropdown-item { color: #e0e0e0 !important; }
        [data-bs-theme="dark"] .dropdown-item:hover { background-color: #333 !important; color: #fff !important; }
 
        [data-bs-theme="dark"] .alert-info { 
            background-color: #2d2d2d !important; 
            border-color: #444 !important; 
            color: #e0e0e0 !important; 
        }

        /* FOOTER Y FONDOS BLANCOS EN MODO OSCURO */
        [data-bs-theme="dark"] footer,
        [data-bs-theme="dark"] .footer,
        [data-bs-theme="dark"] .bg-white {
            background-color: #121212 !important;
            color: #b0b0b0 !important;
            border-top: 1px solid #333 !important;
        }

        /* MODOS DE ACCESIBILIDAD AVANZADA */
        body.high-contrast-mode {
            background-color: #000000 !important;
            color: #ffff00 !important;
        }
        body.high-contrast-mode .card, 
        body.high-contrast-mode .sidebar, 
        body.high-contrast-mode .topbar {
            background-color: #000000 !important;
            border: 2px solid #ffff00 !important;
            color: #ffff00 !important;
        }
        body.grayscale-mode {
            filter: grayscale(100%) !important;
        }
        body.highlight-links a {
            background-color: #fde047 !important;
            color: #0f172a !important;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
            text-decoration: underline !important;
        }
        body.increased-line-height p, 
        body.increased-line-height li, 
        body.increased-line-height span, 
        body.increased-line-height div {
            line-height: 2.0 !important;
        }

        /* Guía de lectura */
        #reading-guide {
            position: fixed;
            height: 4px;
            background: rgba(14, 165, 233, 0.85);
            width: 100%;
            pointer-events: none;
            z-index: 99998;
            display: none;
            top: 0;
            left: 0;
            box-shadow: 0 0 10px rgba(14, 165, 233, 0.8);
        }
    </style>
</head>

<body>
<div id="reading-guide"></div>

<div class="wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-header mb-4 mt-2">
            <a href="{{ route('admin.dashboard') }}" class="logo-link text-decoration-none d-flex align-items-center gap-3">
                <div class="logo-circle"><img src="{{ asset("imagenes/ContenidoCurso/logo-empleamos-job.png") }}" alt="Empleamos" class="logo-img"></div>
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
                <a href="{{ route('roles.index') }}" class="config-link"><i class="fas fa-user-tag"></i> Roles</a>
                <a href="{{ route('permissions.index') }}" class="config-link"><i class="fas fa-key"></i> Permisos</a>
                <a href="{{ route('areas.index') }}"><i class="fa-solid fa-building"></i> Áreas</a>
                <a href="{{ route('cursos.index') }}"><i class="fa-solid fa-book-open"></i> Cursos</a>
                <a href="{{ route('parametros.edit') }}" class="config-link"><i class="fas fa-cog"></i> Configuración</a>
            @else
                <a href="{{ route('estudiante.dashboard') }}"><i class="fa-solid fa-house"></i> Mis cursos</a>
            @endif
        </nav>
    </aside>

    <!-- CONTENIDO PRINCIPAL (TOPBAR LIMPIA SIN TÍTULO MOLESTO) -->
    <div class="main-content">
        <header class="topbar d-flex justify-content-end align-items-center px-4">
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
            @yield('content')
        </main>
        
        @include('layouts.footer')
    </div>
</div>

<!-- MINI PANEL FLOTANTE Y ARRASTRABLE DE ACCESIBILIDAD -->
<div id="accessibility-widget" style="position: fixed; bottom: 25px; right: 25px; z-index: 9999;">
    <!-- Botón flotante principal -->
    <button id="accessibility-toggle" class="btn shadow-lg rounded-circle d-flex align-items-center justify-content-center" title="Panel de Accesibilidad Humana" style="width: 55px; height: 55px; background-color: #0b0f19; border: 2px solid rgba(255,255,255,0.2);">
        <i class="fa-solid fa-universal-access fa-lg text-info"></i>
    </button>

    <!-- Contenido del Panel Desplegable -->
    <div id="accessibility-panel" class="card shadow-lg border-0 p-3 rounded-4" style="display: none; position: fixed; bottom: 90px; right: 25px; width: 290px; background-color: #121826; color: #fff; border: 1px solid rgba(255,255,255,0.15);">
        
        <!-- Cabecera Arrastrable -->
        <div id="panel-header" class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2 border-secondary" style="cursor: move; user-select: none;" title="Haz clic sostenido aquí para arrastrar el panel">
            <h6 class="fw-bold text-info mb-0">
                <i class="fa-solid fa-arrows-up-down-left-right me-1"></i> Confort y Accesibilidad
            </h6>
            <button type="button" class="btn-close btn-close-white btn-sm" id="close-panel" aria-label="Cerrar"></button>
        </div>

        <!-- 1. Apariencia -->
        <div class="mb-2">
            <label class="form-label small fw-semibold text-muted mb-1">Apariencia Visual</label>
            <button id="btn-theme-toggle" class="btn btn-sm btn-outline-light w-100 d-flex align-items-center justify-content-center gap-2 py-1">
                <i class="fa-solid fa-sun" id="theme-icon"></i> <span id="theme-text">Modo Claro</span>
            </button>
        </div>

        <!-- 2. Tamaño de Texto -->
        <div class="mb-2">
            <label class="form-label small fw-semibold text-muted mb-1">Tamaño de Texto</label>
            <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-sm btn-outline-secondary text-white" onclick="adjustFontSize(-1)">A-</button>
                <button type="button" class="btn btn-sm btn-outline-secondary text-white" onclick="resetFontSize()">Normal</button>
                <button type="button" class="btn btn-sm btn-outline-secondary text-white" onclick="adjustFontSize(1)">A+</button>
            </div>
        </div>

        <!-- 3. Herramientas Humanas Avanzadas -->
        <div class="mb-2">
            <label class="form-label small fw-semibold text-muted mb-1">Herramientas de Apoyo</label>
            <div class="d-grid gap-1">
                <button id="btn-contrast-toggle" class="btn btn-sm btn-outline-secondary text-white d-flex align-items-center justify-content-between px-2 py-1">
                    <span><i class="fa-solid fa-circle-half-stroke me-1"></i> Alto Contraste</span>
                    <small id="contrast-status" class="text-muted">Off</small>
                </button>
                <button id="btn-grayscale-toggle" class="btn btn-sm btn-outline-secondary text-white d-flex align-items-center justify-content-between px-2 py-1">
                    <span><i class="fa-solid fa-eye me-1"></i> Reducir Fatiga Visual</span>
                    <small id="grayscale-status" class="text-muted">Off</small>
                </button>
                <button id="btn-links-toggle" class="btn btn-sm btn-outline-secondary text-white d-flex align-items-center justify-content-between px-2 py-1">
                    <span><i class="fa-solid fa-link me-1"></i> Resaltar Enlaces</span>
                    <small id="links-status" class="text-muted">Off</small>
                </button>
                <button id="btn-spacing-toggle" class="btn btn-sm btn-outline-secondary text-white d-flex align-items-center justify-content-between px-2 py-1">
                    <span><i class="fa-solid fa-text-height me-1"></i> Espaciado de Texto</span>
                    <small id="spacing-status" class="text-muted">Off</small>
                </button>
                <button id="btn-guide-toggle" class="btn btn-sm btn-outline-secondary text-white d-flex align-items-center justify-content-between px-2 py-1">
                    <span><i class="fa-solid fa-ruler-horizontal me-1"></i> Guía de Lectura</span>
                    <small id="guide-status" class="text-muted">Off</small>
                </button>
            </div>
        </div>

        <!-- Botón de Restablecer Todo -->
        <div class="mt-2 pt-2 border-top border-secondary text-center">
            <button class="btn btn-link text-danger btn-sm text-decoration-none p-0" onclick="resetAllAccessibility()" style="font-size: 0.8rem;">
                <i class="fa-solid fa-rotate-right me-1"></i> Restablecer valores predeterminados
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const html = document.documentElement;

        const savedTheme = localStorage.getItem('theme') || 'light';
        html.setAttribute('data-bs-theme', savedTheme);
        updateThemeUI(savedTheme);

        if (localStorage.getItem('high_contrast') === 'on') {
            document.body.classList.add('high-contrast-mode');
            document.getElementById('contrast-status').innerText = 'On';
        }
        if (localStorage.getItem('grayscale') === 'on') {
            document.body.classList.add('grayscale-mode');
            document.getElementById('grayscale-status').innerText = 'On';
        }
        if (localStorage.getItem('highlight_links') === 'on') {
            document.body.classList.add('highlight-links');
            document.getElementById('links-status').innerText = 'On';
        }
        if (localStorage.getItem('increased_spacing') === 'on') {
            document.body.classList.add('increased-line-height');
            document.getElementById('spacing-status').innerText = 'On';
        }
        if (localStorage.getItem('reading_guide') === 'on') {
            document.getElementById('reading-guide').style.display = 'block';
            document.getElementById('guide-status').innerText = 'On';
        }

        const toggleBtn = document.getElementById('accessibility-toggle');
        const panel = document.getElementById('accessibility-panel');
        const closeBtn = document.getElementById('close-panel');

        toggleBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            panel.style.display = panel.style.display === 'none' ? 'block' : 'none';
        });

        closeBtn.addEventListener('click', function() {
            panel.style.display = 'none';
        });

        const themeBtn = document.getElementById('btn-theme-toggle');
        themeBtn.addEventListener('click', function() {
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
            updateThemeUI(next);
        });

        function updateThemeUI(theme) {
            const themeIcon = document.getElementById('theme-icon');
            const themeText = document.getElementById('theme-text');
            if (theme === 'dark') {
                themeIcon.className = 'fa-solid fa-moon text-info';
                themeText.innerText = 'Modo Oscuro';
            } else {
                themeIcon.className = 'fa-solid fa-sun text-warning';
                themeText.innerText = 'Modo Claro';
            }
        }

        document.getElementById('btn-contrast-toggle').addEventListener('click', function() {
            document.body.classList.toggle('high-contrast-mode');
            const isOn = document.body.classList.contains('high-contrast-mode');
            localStorage.setItem('high_contrast', isOn ? 'on' : 'off');
            document.getElementById('contrast-status').innerText = isOn ? 'On' : 'Off';
        });

        document.getElementById('btn-grayscale-toggle').addEventListener('click', function() {
            document.body.classList.toggle('grayscale-mode');
            const isOn = document.body.classList.contains('grayscale-mode');
            localStorage.setItem('grayscale', isOn ? 'on' : 'off');
            document.getElementById('grayscale-status').innerText = isOn ? 'On' : 'Off';
        });

        document.getElementById('btn-links-toggle').addEventListener('click', function() {
            document.body.classList.toggle('highlight-links');
            const isOn = document.body.classList.contains('highlight-links');
            localStorage.setItem('highlight_links', isOn ? 'on' : 'off');
            document.getElementById('links-status').innerText = isOn ? 'On' : 'Off';
        });

        document.getElementById('btn-spacing-toggle').addEventListener('click', function() {
            document.body.classList.toggle('increased-line-height');
            const isOn = document.body.classList.contains('increased-line-height');
            localStorage.setItem('increased_spacing', isOn ? 'on' : 'off');
            document.getElementById('spacing-status').innerText = isOn ? 'On' : 'Off';
        });

        const guideEl = document.getElementById('reading-guide');
        document.getElementById('btn-guide-toggle').addEventListener('click', function() {
            const isVisible = guideEl.style.display === 'block';
            guideEl.style.display = isVisible ? 'none' : 'block';
            localStorage.setItem('reading_guide', isVisible ? 'off' : 'on');
            document.getElementById('guide-status').innerText = isVisible ? 'Off' : 'On';
        });

        document.addEventListener('mousemove', function(e) {
            if (guideEl.style.display === 'block') {
                guideEl.style.top = (e.clientY + 15) + 'px';
            }
        });

        const header = document.getElementById('panel-header');
        let isDragging = false;
        let startX, startY, initialLeft, initialTop;

        header.addEventListener('mousedown', function(e) {
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;

            const rect = panel.getBoundingClientRect();
            panel.style.bottom = 'auto';
            panel.style.right = 'auto';
            panel.style.left = rect.left + 'px';
            panel.style.top = rect.top + 'px';

            initialLeft = rect.left;
            initialTop = rect.top;

            document.addEventListener('mousemove', onMouseMove);
            document.addEventListener('mouseup', onMouseUp);
        });

        function onMouseMove(e) {
            if (!isDragging) return;
            const dx = e.clientX - startX;
            const dy = e.clientY - startY;
            panel.style.left = (initialLeft + dx) + 'px';
            panel.style.top = (initialTop + dy) + 'px';
        }

        function onMouseUp() {
            isDragging = false;
            document.removeEventListener('mousemove', onMouseMove);
            document.removeEventListener('mouseup', onMouseUp);
        }
    });

    let currentFontSize = 16; 
    function adjustFontSize(direction) {
        currentFontSize += direction * 2;
        if (currentFontSize < 12) currentFontSize = 12;
        if (currentFontSize > 22) currentFontSize = 22;
        document.body.style.fontSize = currentFontSize + 'px';
    }

    let resetFontSize = function() {
        currentFontSize = 16;
        document.body.style.fontSize = '16px';
    }

    let resetAllAccessibility = function() {
        localStorage.clear();
        location.reload();
    }
</script>
</body>
</html>