@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')
    <div class="mb-4">
        <h2 class="fw-bold mb-1">Bienvenido, {{ auth()->user()->name }} 👋</h2>
        <p class="text-muted mb-0">Gestiona la academia corporativa de Empleamos Temporales.</p>
    </div>

    {{-- Tarjetas métricas --}}
    <div class="dashboard-grid mb-4">
        <div class="metric-card">
            <div class="metric-icon bg-usuarios">
                <i class="fa-solid fa-users"></i>
            </div>
            <h3 class="fw-bold">{{ \App\Models\User::count() }}</h3>
            <p class="text-muted mb-0">Usuarios registrados</p>
        </div>

        <div class="metric-card">
            <div class="metric-icon bg-cursos">
                <i class="fa-solid fa-book-open"></i>
            </div>
            <h3 class="fw-bold">{{ \App\Models\Curso::count() }}</h3>
            <p class="text-muted mb-0">Cursos activos</p>
        </div>

        <div class="metric-card">
            <div class="metric-icon bg-modulos">
                <i class="fa-solid fa-layer-group"></i>
            </div>
            <h3 class="fw-bold">{{ \App\Models\Modulo::count() }}</h3>
            <p class="text-muted mb-0">Módulos creados</p>
        </div>

        <div class="metric-card">
            <div class="metric-icon bg-cert">
                <i class="fa-solid fa-certificate"></i>
            </div>
            <h3 class="fw-bold">{{ \App\Models\Certificado::count() }}</h3>
            <p class="text-muted mb-0">Certificados emitidos</p>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card p-4 h-100">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">Módulos destacados</h5>
                        <small class="text-muted">Acceso rápido a las capacitaciones principales</small>
                    </div>
                    <a href="{{ route('cursos.index') }}" class="btn btn-primary btn-sm">Ver todos</a>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="module-card">
                            <div class="module-banner"></div>
                            <div class="module-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-primary-subtle text-primary">Inducción</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-muted"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Bienvenida Corporativa</h6>
                                <p class="text-muted small mb-3">Mensaje del gerente, cultura y lineamientos generales.</p>
                                <div class="progress mb-2">
                                    <div class="progress-bar" style="width: 82%"></div>
                                </div>
                                <small class="text-muted">82% completado</small>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="module-card">
                            <div class="module-banner"></div>
                            <div class="module-body">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <span class="badge bg-primary-subtle text-primary">SST</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-muted"></i>
                                </div>
                                <h6 class="fw-bold mb-2">Seguridad y Salud</h6>
                                <p class="text-muted small mb-3">Riesgos, EPP y procedimientos de emergencia.</p>
                                <div class="progress mb-2">
                                    <div class="progress-bar" style="width: 45%"></div>
                                </div>
                                <small class="text-muted">45% completado</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card p-4 mb-4">
                <h5 class="fw-bold mb-3">Accesos rápidos</h5>
                <div class="d-grid gap-3">
                    <a href="{{ route('areas.create') }}" class="btn btn-outline-primary text-start">
                        <i class="fa-solid fa-building me-2"></i> Crear área
                    </a>
                    <a href="{{ route('usuarios.create') }}" class="btn btn-primary text-start">
                        <i class="fa-solid fa-user-plus me-2"></i> Crear usuario
                    </a>
                    <a href="{{ route('cursos.create') }}" class="btn btn-outline-primary text-start">
                        <i class="fa-solid fa-book me-2"></i> Crear curso
                    </a>
                    <a href="{{ route('modulos.create') }}" class="btn btn-outline-primary text-start">
                        <i class="fa-solid fa-layer-group me-2"></i> Crear módulo
                    </a>
                    <a href="{{ route('evaluaciones.create') }}" class="btn btn-outline-primary text-start">
                        <i class="fa-solid fa-file-pen me-2"></i> Crear evaluación
                    </a>
                </div>
            </div>

            <div class="card p-4">
                <h5 class="fw-bold mb-3">Estado del sistema</h5>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Servidor local</span>
                    <span class="text-success fw-semibold">Activo</span>
                </div>
                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span>Base de datos</span>
                    <span class="text-success fw-semibold">Conectada</span>
                </div>
                <div class="d-flex justify-content-between py-2">
                    <span>Storage público</span>
                    <span class="text-success fw-semibold">Listo</span>
                </div>
            </div>
        </div>
    </div>
@endsection