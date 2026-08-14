@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

    {{-- REGLAS MÁGICAS PARA EL MODO OSCURO --}}
    <style>
        /* Fondo general */
        [data-bs-theme="dark"] body, 
        [data-bs-theme="dark"] .bg-body {
            background-color: #121212 !important;
            color: #e0e0e0 !important;
        }
        
        /* Tarjetas del panel */
        [data-bs-theme="dark"] .card,
        [data-bs-theme="dark"] .metric-card,
        [data-bs-theme="dark"] .module-card {
            background-color: #1e1e1e !important;
            border-color: #333333 !important;
            box-shadow: 0 4px 6px rgba(0,0,0,0.5) !important;
            color: #ffffff !important;
        }

        /* Listas y fondos claros */
        [data-bs-theme="dark"] .bg-light {
            background-color: #2d2d2d !important;
            color: #ffffff !important;
        }
        
        /* Protegemos el menú lateral: Solo oscurecemos las listas dentro de las tarjetas centrales */
        [data-bs-theme="dark"] .card .list-group-item {
            background-color: #2d2d2d !important;
            border-color: #444444 !important;
            color: #ffffff !important;
        }

        /* Textos y títulos */
        [data-bs-theme="dark"] .text-muted {
            color: #a0a0a0 !important;
        }
        
        [data-bs-theme="dark"] h1, [data-bs-theme="dark"] h2, 
        [data-bs-theme="dark"] h3, [data-bs-theme="dark"] h4, 
        [data-bs-theme="dark"] h5, [data-bs-theme="dark"] h6 {
            color: #ffffff !important;
        }
        
        [data-bs-theme="dark"] .border-bottom {
            border-color: #333333 !important;
        }

        /* =========================================
           OSCURECER SOLO LA BARRA SUPERIOR
           ========================================= */
        [data-bs-theme="dark"] header,
        [data-bs-theme="dark"] .navbar,
        [data-bs-theme="dark"] header.bg-white {
            background-color: #1e1e1e !important;
            border-bottom: 1px solid #333 !important;
            color: #ffffff !important;
        }

        [data-bs-theme="dark"] header a,
        [data-bs-theme="dark"] header span,
        [data-bs-theme="dark"] header .text-gray-800,
        [data-bs-theme="dark"] header .text-gray-500 {
            color: #e0e0e0 !important;
        }
    </style>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Bienvenido, {{ auth()->user()->name }} 👋</h2>
            <p class="text-muted mb-0">Gestiona la academia corporativa de Empleamos Temporales.</p>
        </div>
        <!-- Botón de Modo Oscuro / Claro -->
        <button id="theme-toggle" class="btn btn-outline-secondary rounded-circle px-3 py-2" title="Cambiar tema">
            <i class="fa-solid fa-moon" id="theme-icon"></i>
        </button>
    </div>

    <div class="row g-4">
        <!-- ==========================================
             COLUMNA IZQUIERDA (Centro Principal) 
        =========================================== -->
        <div class="col-lg-8">
            
            <!-- 1. CURSOS RECIENTES -->
            <div class="card shadow-sm border-0 p-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h5 class="fw-bold mb-1">Cursos Recientes</h5>
                        <small class="text-muted">Últimos cursos añadidos a la plataforma</small>
                    </div>
                    <a href="{{ route('cursos.index') }}" class="btn btn-primary btn-sm">Ver todos</a>
                </div>

                <div class="row g-4">
                    @forelse($ultimosCursos as $curso)
                        <div class="col-md-6">
                            <!-- NOTA: Agregamos position-relative y el efecto hover -->
                            <div class="module-card border rounded p-3 h-100 shadow-sm position-relative" style="transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                                <div class="module-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <span class="badge {{ $curso->estado == 'activo' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                            {{ strtoupper($curso->estado) }}
                                        </span>
                                        <i class="fa-solid fa-book text-muted"></i>
                                    </div>
                                    <h6 class="fw-bold mb-2">
                                        <!-- Enlace estirado (stretched-link) -->
                                        <a href="{{ route('cursos.show', $curso->id) }}" class="text-decoration-none text-primary stretched-link">
                                            {{ $curso->nombre }}
                                        </a>
                                    </h6>
                                    <p class="text-muted small mb-3">{{ Str::limit($curso->descripcion, 60) }}</p>
                                    <small class="text-muted fw-semibold">Registrado: {{ $curso->created_at->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center text-muted py-4 bg-light rounded">
                            <i class="fa-solid fa-folder-open mb-2 text-secondary" style="font-size: 24px;"></i><br>
                            Aún no hay cursos creados.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 2. ESTUDIANTES REGISTRADOS CON SU ROL -->
            <div class="card shadow-sm border-0 p-4">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <h5 class="fw-bold mb-0">Usuarios Registrados</h5>
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-sm">Ver todos</a>
                </div>
                
                <ul class="list-group list-group-flush">
                    @forelse($ultimosUsuarios as $usuario)
                        @php
                            $rolName = $usuario->getRoleNames()->first();
                            $badgeClass = 'bg-secondary';
                            
                            if($rolName == 'Admin' || $rolName == 'SuperAdmin') {
                                $badgeClass = 'bg-danger';
                            } elseif($rolName == 'estudiante') {
                                $badgeClass = 'bg-primary';
                            }
                        @endphp
                        
                        <li class="list-group-item d-flex justify-content-between align-items-center px-2 py-3 border-bottom">
                            <div class="d-flex align-items-center">
                                <div class="bg-light rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 40px; height: 40px;">
                                    <i class="fa-solid fa-user text-secondary"></i>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $usuario->name }}</h6>
                                    <small class="text-muted">{{ $usuario->email }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="badge {{ $badgeClass }} rounded-pill px-3 py-2 mb-1">
                                    Usuario {{ ucfirst($rolName ?? 'Nuevo') }}
                                </span>
                                <br>
                                <small class="text-muted" style="font-size: 0.75rem;">Se unió {{ $usuario->created_at->diffForHumans() }}</small>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item px-0 text-center text-muted py-4">No hay registros recientes.</li>
                    @endforelse
                </ul>
            </div>

        </div>

        <!-- ==========================================
             COLUMNA DERECHA (Tarjetas y Estado) 
        =========================================== -->
        <div class="col-lg-4">
            
            <h5 class="fw-bold mb-3">Resumen de Métricas</h5>
            
            <!-- TARJETAS APILADAS VERTICALMENTE -->
            <div class="d-flex flex-column gap-3 mb-4">
                
                <!-- Tarjeta Estudiantes Clickable -->
                <div class="metric-card card shadow-sm border-0 p-3 d-flex flex-row align-items-center position-relative" style="transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="metric-icon bg-usuarios me-3 d-flex justify-content-center align-items-center rounded" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-users text-primary fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">
                            <!-- Enlace a la vista de usuarios -->
                            <a href="{{ route('usuarios.index') }}" class="text-decoration-none text-reset stretched-link">
                                {{ $stats['total_estudiantes'] ?? 0 }}
                            </a>
                        </h4>
                        <p class="text-muted mb-0 small text-uppercase fw-semibold">Estudiantes</p>
                    </div>
                </div>

                <!-- Tarjeta Cursos Totales Clickable -->
                <div class="metric-card card shadow-sm border-0 p-3 d-flex flex-row align-items-center position-relative" style="transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="metric-icon bg-cursos me-3 d-flex justify-content-center align-items-center rounded" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-book-open text-success fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">
                            <!-- Enlace a la vista de cursos -->
                            <a href="{{ route('cursos.index') }}" class="text-decoration-none text-reset stretched-link">
                                {{ $stats['total_cursos'] ?? 0 }}
                            </a>
                        </h4>
                        <p class="text-muted mb-0 small text-uppercase fw-semibold">Cursos totales</p>
                    </div>
                </div>

                <!-- Tarjeta Cursos Activos Clickable -->
                <div class="metric-card card shadow-sm border-0 p-3 d-flex flex-row align-items-center position-relative" style="transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                    <div class="metric-icon bg-modulos me-3 d-flex justify-content-center align-items-center rounded" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-layer-group text-warning fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">
                            <a href="{{ route('cursos.index') }}" class="text-decoration-none text-reset stretched-link">
                                {{ $stats['cursos_activos'] ?? 0 }}
                            </a>
                        </h4>
                        <p class="text-muted mb-0 small text-uppercase fw-semibold">Cursos activos</p>
                    </div>
                </div>

                <!-- Tarjeta Certificados -->
                <div class="metric-card card shadow-sm border-0 p-3 d-flex flex-row align-items-center">
                    <div class="metric-icon bg-cert me-3 d-flex justify-content-center align-items-center rounded" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-certificate text-danger fs-4"></i>
                    </div>
                    <div>
                        <h4 class="fw-bold mb-0">{{ \App\Models\Certificado::count() }}</h4>
                        <p class="text-muted mb-0 small text-uppercase fw-semibold">Certificados</p>
                    </div>
                </div>

            </div>

            <!-- ESTADO DEL SISTEMA -->
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-3">Estado del sistema</h5>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Servidor local</span>
                    <span class="text-success fw-bold">Activo</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Base de datos</span>
                    <span class="text-success fw-bold">Conectada</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span class="text-muted">Storage público</span>
                    <span class="text-success fw-bold">Listo</span>
                </div>
            </div>
            
        </div>
    </div>

    {{-- Script para el Modo Oscuro / Claro --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const themeToggleBtn = document.getElementById('theme-toggle');
            const themeIcon = document.getElementById('theme-icon');
            const htmlElement = document.documentElement; 
            const bodyElement = document.body;

            const currentTheme = localStorage.getItem('theme') || 'light';
            htmlElement.setAttribute('data-bs-theme', currentTheme);
            bodyElement.setAttribute('data-bs-theme', currentTheme);
            updateIcon(currentTheme);

            themeToggleBtn.addEventListener('click', function() {
                const newTheme = htmlElement.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
                
                htmlElement.setAttribute('data-bs-theme', newTheme);
                bodyElement.setAttribute('data-bs-theme', newTheme);
                
                localStorage.setItem('theme', newTheme);
                updateIcon(newTheme);
            });

            function updateIcon(theme) {
                if (theme === 'dark') {
                    themeIcon.classList.remove('fa-moon');
                    themeIcon.classList.add('fa-sun');
                } else {
                    themeIcon.classList.remove('fa-sun');
                    themeIcon.classList.add('fa-moon');
                }
            }
        });
    </script>
@endsection