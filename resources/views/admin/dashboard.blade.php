@extends('layouts.app')

@section('page-title', 'Dashboard')

@section('content')

<style>
    /* =========================================================
        DASHBOARD CORPORATIVO
    ========================================================= */

    :root {
        --primary: #2563eb;
        --primary-light: #eff6ff;
        --success: #16a34a;
        --warning: #d97706;
        --danger: #dc2626;
        --purple: #7c3aed;

        --bg: #f5f7fb;
        --card: #ffffff;
        --border: #e5e7eb;

        --text: #111827;
        --muted: #6b7280;

        --radius: 18px;
    }

    /* =========================================================
        FONDO
    ========================================================= */

    .dashboard-wrapper {
        background: var(--bg);
        min-height: calc(100vh - 80px);
        padding: 15px 0 45px;
    }

    /* =========================================================
        ENCABEZADO
    ========================================================= */

    .dashboard-header {
        margin-bottom: 28px;
    }

    .dashboard-label {
        display: inline-flex;
        align-items: center;
        gap: 7px;

        padding: 6px 12px;
        margin-bottom: 10px;

        border-radius: 50px;

        background: rgba(37, 99, 235, .08);
        color: var(--primary);

        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    .dashboard-label span {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: var(--success);

        box-shadow: 0 0 0 4px rgba(22,163,74,.10);
    }

    .dashboard-header h2 {
        color: var(--text);
        font-size: 1.8rem;
        font-weight: 800;
        letter-spacing: -.5px;
    }

    .dashboard-header p {
        color: var(--muted);
        font-size: .9rem;
    }

    /* =========================================================
        TARJETAS DE MÉTRICAS
    ========================================================= */

    .dashboard-metric {
        position: relative;
        height: 100%;
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        padding: 20px;
        overflow: hidden;
        transition: all .25s ease;
    }

    .dashboard-metric:hover {
        transform: translateY(-4px);
        border-color: rgba(37,99,235,.25);
        box-shadow: 0 15px 35px rgba(15,23,42,.08);
    }

    .dashboard-metric::after {
        content: "";
        position: absolute;
        width: 100px;
        height: 100px;
        right: -35px;
        top: -35px;
        border-radius: 50%;
        background: rgba(37,99,235,.05);
    }

    .metric-content {
        position: relative;
        z-index: 2;
    }

    .metric-icon {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        margin-bottom: 15px;
        font-size: 1.1rem;
    }

    .metric-icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .metric-icon.green {
        background: #ecfdf5;
        color: #16a34a;
    }

    .metric-icon.orange {
        background: #fff7ed;
        color: #d97706;
    }

    .metric-icon.red {
        background: #fef2f2;
        color: #dc2626;
    }

    .metric-number {
        font-size: 1.8rem;
        line-height: 1;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 7px;
    }

    .metric-title {
        color: var(--muted);
        font-size: .72rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .5px;
    }

    /* =========================================================
        TARJETAS GENERALES
    ========================================================= */

    .dashboard-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 4px 18px rgba(15,23,42,.04);
    }

    .section-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: var(--text);
        margin-bottom: 3px;
    }

    .section-subtitle {
        font-size: .78rem;
        color: var(--muted);
    }

    .btn-dashboard {
        border-radius: 10px;
        font-size: .75rem;
        font-weight: 700;
        padding: 8px 13px;
    }

    /* =========================================================
        CURSOS
    ========================================================= */

    .curso-card {
        position: relative;
        height: 305px;
        border-radius: 18px;
        overflow: hidden;
        background: #111827;
        transition: all .3s ease;
    }

    .curso-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 18px 40px rgba(15,23,42,.18);
    }

    .curso-card .carousel,
    .curso-card .carousel-inner,
    .curso-card .carousel-item {
        height: 100%;
    }

    .curso-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .5s ease;
    }

    .curso-card:hover img {
        transform: scale(1.04);
    }

    .curso-overlay {
        position: absolute;
        inset: 0;
        z-index: 2;
        background: linear-gradient(
            to bottom,
            rgba(0,0,0,.03) 0%,
            rgba(0,0,0,.10) 30%,
            rgba(0,0,0,.90) 100%
        );
    }

    .curso-content {
        position: absolute;
        inset: 0;
        z-index: 3;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: white;
    }

    .curso-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 50px;
        font-size: .65rem;
        font-weight: 800;
        text-transform: uppercase;
        background: rgba(22,163,74,.92);
        width: fit-content;
        backdrop-filter: blur(5px);
    }

    .curso-status.inactive {
        background: rgba(107,114,128,.92);
    }

    .curso-status-dot {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: white;
    }

    .curso-title {
        font-size: 1.1rem;
        font-weight: 800;
        color: white;
        margin-bottom: 5px;
    }

    .curso-description {
        color: rgba(255,255,255,.78);
        font-size: .75rem;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .curso-action {
        color: white;
        font-size: .75rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .curso-action:hover {
        color: white;
        gap: 9px;
    }

    /* =========================================================
        USUARIOS
    ========================================================= */

    .recent-users-list {
        display: flex;
        flex-direction: column;
    }

    .recent-user {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 14px 4px;
        border-bottom: 1px solid #edf0f4;
        transition: all .2s ease;
    }

    .recent-user:last-child {
        border-bottom: none;
    }

    .recent-user:hover {
        background: #fafbfc;
        padding-left: 10px;
        padding-right: 10px;
        border-radius: 12px;
    }

    .user-main {
        display: flex;
        align-items: center;
        min-width: 0;
    }

    .user-avatar-modern {
        width: 42px;
        height: 42px;
        min-width: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        background: linear-gradient(
            135deg,
            #eff6ff,
            #dbeafe
        );
        color: #2563eb;
        font-size: .75rem;
        font-weight: 800;
        margin-right: 13px;
    }

    .user-information {
        min-width: 0;
    }

    .user-name-modern {
        font-size: .84rem;
        font-weight: 800;
        color: #111827;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .user-email-modern {
        font-size: .72rem;
        color: #6b7280;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        margin-top: 2px;
    }

    .user-meta {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 5px;
    }

    .role-modern {
        padding: 5px 10px;
        border-radius: 50px;
        font-size: .63rem;
        font-weight: 800;
        white-space: nowrap;
    }

    .role-modern.admin {
        background: #fee2e2;
        color: #dc2626;
    }

    .role-modern.student {
        background: #dbeafe;
        color: #2563eb;
    }

    .role-modern.default {
        background: #f3f4f6;
        color: #6b7280;
    }

    .user-date {
        font-size: .63rem;
        color: #9ca3af;
    }

    /* =========================================================
        ESTADO DEL SISTEMA
    ========================================================= */

    .system-live {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 9px;
        border-radius: 50px;
        background: #ecfdf5;
        color: #059669;
        font-size: .63rem;
        font-weight: 800;
    }

    .system-live span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: #10b981;
        box-shadow: 0 0 0 3px rgba(16,185,129,.12);
    }

    .system-grid {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .system-service {
        display: flex;
        align-items: center;
        padding: 11px;
        border: 1px solid #edf0f4;
        border-radius: 13px;
        transition: all .2s ease;
    }

    .system-service:hover {
        border-color: #dbeafe;
        background: #f9fbff;
        transform: translateX(3px);
    }

    .system-service-icon {
        width: 36px;
        height: 36px;
        min-width: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        margin-right: 11px;
        font-size: .8rem;
    }

    .system-service-icon.blue {
        background: #eff6ff;
        color: #2563eb;
    }

    .system-service-icon.green {
        background: #ecfdf5;
        color: #059669;
    }

    .system-service-icon.purple {
        background: #f5f3ff;
        color: #7c3aed;
    }

    .system-service-info {
        flex: 1;
    }

    .system-service-name {
        font-size: .75rem;
        font-weight: 800;
        color: #374151;
    }

    .system-service-status {
        font-size: .63rem;
        color: #9ca3af;
        margin-top: 2px;
    }

    .system-check {
        width: 23px;
        height: 23px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #ecfdf5;
        color: #10b981;
        font-size: .6rem;
    }

    /* =========================================================
        ACCESOS RÁPIDOS
    ========================================================= */

    .quick-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        text-decoration: none;
        color: var(--text);
        padding: 11px 0;
        border-bottom: 1px solid var(--border);
        transition: all .2s ease;
    }

    .quick-link:last-child {
        border-bottom: none;
    }

    .quick-link:hover {
        color: var(--primary);
        padding-left: 5px;
    }

    .quick-link-content {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: .78rem;
        font-weight: 700;
    }

    .quick-link-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: var(--primary-light);
        color: var(--primary);
    }

    /* =========================================================
        ESTADO VACÍO
    ========================================================= */

    .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: var(--muted);
        background: #f9fafb;
        border-radius: 14px;
    }

    .empty-state-icon {
        font-size: 2rem;
        margin-bottom: 10px;
        color: #9ca3af;
    }

    /* =========================================================
        MODO OSCURO
    ========================================================= */

    [data-bs-theme="dark"] .dashboard-wrapper {
        background: #111827;
    }

    [data-bs-theme="dark"] .dashboard-card,
    [data-bs-theme="dark"] .dashboard-metric {
        background: #1f2937;
        border-color: #374151;
        box-shadow: 0 5px 20px rgba(0,0,0,.18);
    }

    [data-bs-theme="dark"] .dashboard-header h2,
    [data-bs-theme="dark"] .section-title,
    [data-bs-theme="dark"] .metric-number,
    [data-bs-theme="dark"] .user-name-modern,
    [data-bs-theme="dark"] .quick-link {
        color: #f9fafb;
    }

    [data-bs-theme="dark"] .recent-user {
        border-color: #374151;
    }

    [data-bs-theme="dark"] .recent-user:hover {
        background: #18212f;
    }

    [data-bs-theme="dark"] .user-avatar-modern {
        background: rgba(59,130,246,.15);
        color: #60a5fa;
    }

    [data-bs-theme="dark"] .user-email-modern {
        color: #9ca3af;
    }

    [data-bs-theme="dark"] .system-service {
        border-color: #374151;
    }

    [data-bs-theme="dark"] .system-service:hover {
        background: #18212f;
        border-color: #475569;
    }

    [data-bs-theme="dark"] .system-service-name {
        color: #f9fafb;
    }

    [data-bs-theme="dark"] .empty-state {
        background: #111827;
    }

    /* =========================================================
        RESPONSIVE
    ========================================================= */

    @media (max-width: 991px) {
        .dashboard-header h2 {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 575px) {
        .dashboard-wrapper {
            padding-top: 5px;
        }

        .dashboard-header {
            margin-bottom: 20px;
        }

        .metric-number {
            font-size: 1.5rem;
        }

        .curso-card {
            height: 280px;
        }

        .recent-user {
            gap: 10px;
        }

        .user-email-modern {
            max-width: 180px;
        }
    }
</style>


<div class="dashboard-wrapper">

    <div class="container-fluid px-3 px-lg-4">

        {{-- =====================================================
            ENCABEZADO
        ====================================================== --}}

        <div class="dashboard-header">
            <div class="dashboard-label">
                <span></span>
                Academia Corporativa
            </div>

            <h2 class="mb-1">
                Bienvenido, {{ auth()->user()->name }}
            </h2>

            <p class="mb-0">
                Gestiona el aprendizaje y la formación corporativa de Empleamos Temporales.
            </p>
        </div>


        {{-- =====================================================
            MÉTRICAS
        ====================================================== --}}

        <div class="row g-3 mb-4">

            {{-- USUARIOS --}}
            <div class="col-6 col-xl-3">
                <div class="dashboard-metric">
                    <div class="metric-content">
                        <div class="metric-icon blue">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <div class="metric-number">
                            {{ $stats['total_estudiantes'] ?? 0 }}
                        </div>
                        <div class="metric-title">
                            Usuarios registrados
                        </div>
                    </div>
                </div>
            </div>

            {{-- CURSOS --}}
            <div class="col-6 col-xl-3">
                <div class="dashboard-metric">
                    <div class="metric-content">
                        <div class="metric-icon green">
                            <i class="fa-solid fa-book-open"></i>
                        </div>
                        <div class="metric-number">
                            {{ $stats['total_cursos'] ?? 0 }}
                        </div>
                        <div class="metric-title">
                            Cursos totales
                        </div>
                    </div>
                </div>
            </div>

            {{-- CURSOS ACTIVOS --}}
            <div class="col-6 col-xl-3">
                <div class="dashboard-metric">
                    <div class="metric-content">
                        <div class="metric-icon orange">
                            <i class="fa-solid fa-layer-group"></i>
                        </div>
                        <div class="metric-number">
                            {{ $stats['cursos_activos'] ?? 0 }}
                        </div>
                        <div class="metric-title">
                            Cursos activos
                        </div>
                    </div>
                </div>
            </div>

            {{-- CERTIFICADOS --}}
            <div class="col-6 col-xl-3">
                <div class="dashboard-metric">
                    <div class="metric-content">
                        <div class="metric-icon red">
                            <i class="fa-solid fa-certificate"></i>
                        </div>
                        <div class="metric-number">
                            {{ \App\Models\Certificado::count() }}
                        </div>
                        <div class="metric-title">
                            Certificados emitidos
                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- =====================================================
            CONTENIDO
        ====================================================== --}}

        <div class="row g-4">

            {{-- =================================================
                COLUMNA PRINCIPAL
            ================================================== --}}

            <div class="col-xl-8">

                {{-- =================================================
                    CURSOS RECIENTES
                ================================================== --}}

                <div class="dashboard-card p-3 p-lg-4 mb-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <div class="section-title">
                                Cursos recientes
                            </div>
                            <div class="section-subtitle">
                                Últimos cursos añadidos a la plataforma
                            </div>
                        </div>

                        <a href="{{ route('cursos.index') }}" class="btn btn-primary btn-dashboard">
                            Ver todos
                            <i class="fa-solid fa-arrow-right ms-1"></i>
                        </a>
                    </div>


                    <div class="row g-4">

                        @forelse($ultimosCursos as $curso)

                            <div class="col-md-6">

                                <div class="curso-card">

                                    {{-- CARRUSEL --}}
                                    @php $fotosUrls = $curso->fotos_urls; @endphp
                                    <div id="carruselDashboard{{ $curso->id }}" class="carousel slide carousel-fade h-100" data-bs-ride="carousel" data-bs-interval="4000">
                                        <div class="carousel-inner h-100">
                                            @forelse($fotosUrls as $index => $url)
                                                <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }}">
                                                    <img src="{{ $url }}" alt="{{ $curso->nombre }}">
                                                </div>
                                            @empty
                                                {{-- Curso sin fotos: recuadro neutro, sin imagen fija --}}
                                                <div class="carousel-item h-100 active">
                                                    <div class="h-100 w-100 d-flex align-items-center justify-content-center" style="background:#1f2937;">
                                                        <i class="fa-solid fa-image fa-2x text-secondary opacity-50"></i>
                                                    </div>
                                                </div>
                                            @endforelse
                                        </div>
                                    </div>

                                    {{-- DEGRADADO --}}
                                    <div class="curso-overlay"></div>

                                    {{-- CONTENIDO --}}
                                    <div class="curso-content">

                                        <div>
                                            <span class="curso-status {{ !$curso->estado ? 'inactive' : '' }}">
                                                <span class="curso-status-dot"></span>
                                                {{ $curso->estado ? 'Activo' : 'Inactivo' }}
                                            </span>
                                        </div>

                                        <div>
                                            <a href="{{ route('cursos.show', $curso->id) }}" class="text-decoration-none stretched-link">
                                                <div class="curso-title">
                                                    {{ $curso->nombre }}
                                                </div>
                                                <div class="curso-description">
                                                    {{ Str::limit($curso->descripcion, 90) }}
                                                </div>
                                                <span class="curso-action">
                                                    Ver curso
                                                    <i class="fa-solid fa-arrow-right"></i>
                                                </span>
                                            </a>
                                        </div>

                                    </div>

                                </div>

                            </div>

                        @empty

                            <div class="col-12">
                                <div class="empty-state">
                                    <div class="empty-state-icon">
                                        <i class="fa-solid fa-folder-open"></i>
                                    </div>
                                    <div class="fw-semibold mb-1">
                                        Aún no hay cursos creados
                                    </div>
                                    <small>
                                        Cuando se creen nuevos cursos aparecerán aquí.
                                    </small>
                                </div>
                            </div>

                        @endforelse

                    </div>

                </div>


                {{-- =================================================
                    USUARIOS RECIENTES
                ================================================== --}}

                <div class="dashboard-card p-3 p-lg-4">

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <div class="section-title">
                                Usuarios recientes
                            </div>
                            <div class="section-subtitle">
                                Últimos usuarios registrados en la plataforma
                            </div>
                        </div>

                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-dashboard">
                            Ver todos
                        </a>
                    </div>


                    <div class="recent-users-list">

                        @forelse($ultimosUsuarios as $usuario)

                            @php
                                $rolName = $usuario->getRoleNames()->first();

                                if ($rolName == 'Admin' || $rolName == 'SuperAdmin') {
                                    $roleType = 'admin';
                                    $roleLabel = 'Administrador';
                                } elseif ($rolName == 'estudiante') {
                                    $roleType = 'student';
                                    $roleLabel = 'Estudiante';
                                } else {
                                    $roleType = 'default';
                                    $roleLabel = ucfirst($rolName ?? 'Nuevo');
                                }

                                $initials = collect(
                                    explode(' ', trim($usuario->name))
                                )
                                ->filter()
                                ->take(2)
                                ->map(
                                    fn($word) =>
                                    strtoupper(substr($word, 0, 1))
                                )
                                ->implode('');
                            @endphp

                            <div class="recent-user">

                                <div class="user-main">
                                    <div class="user-avatar-modern">
                                        {{ $initials ?: 'U' }}
                                    </div>

                                    <div class="user-information">
                                        <div class="user-name-modern">
                                            {{ $usuario->name }}
                                        </div>
                                        <div class="user-email-modern">
                                            {{ $usuario->email }}
                                        </div>
                                    </div>
                                </div>

                                <div class="user-meta">
                                    <span class="role-modern {{ $roleType }}">
                                        {{ $roleLabel }}
                                    </span>
                                    <span class="user-date">
                                        {{ $usuario->created_at->diffForHumans() }}
                                    </span>
                                </div>

                            </div>

                        @empty

                            <div class="empty-state">
                                <div class="empty-state-icon">
                                    <i class="fa-solid fa-users"></i>
                                </div>
                                <div class="fw-semibold">
                                    No hay usuarios recientes
                                </div>
                            </div>

                        @endforelse

                    </div>

                </div>

            </div>


            {{-- =================================================
                COLUMNA DERECHA
            ================================================== --}}

            <div class="col-xl-4">

                {{-- =================================================
                    ESTADO DEL SISTEMA
                ================================================== --}}

                <div class="dashboard-card p-3 p-lg-4 mb-4">

                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <div class="section-title">
                                Estado del sistema
                            </div>
                            <div class="section-subtitle">
                                Servicios de la plataforma
                            </div>
                        </div>

                        <div class="system-live">
                            <span></span>
                            En línea
                        </div>
                    </div>

                    <div class="system-grid">

                        {{-- SERVIDOR --}}
                        <div class="system-service">
                            <div class="system-service-icon blue">
                                <i class="fa-solid fa-server"></i>
                            </div>
                            <div class="system-service-info">
                                <div class="system-service-name">
                                    Servidor
                                </div>
                                <div class="system-service-status">
                                    Operativo
                                </div>
                            </div>
                            <div class="system-check">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>

                        {{-- BASE DE DATOS --}}
                        <div class="system-service">
                            <div class="system-service-icon green">
                                <i class="fa-solid fa-database"></i>
                            </div>
                            <div class="system-service-info">
                                <div class="system-service-name">
                                    Base de datos
                                </div>
                                <div class="system-service-status">
                                    Conectada
                                </div>
                            </div>
                            <div class="system-check">
                                <i class="fa-solid fa-check"></i>
                            </div>
                        </div>

                    </div>

                </div>


                {{-- =================================================
                    ACCESOS RÁPIDOS
                ================================================== --}}

                <div class="dashboard-card p-3 p-lg-4 mb-4">

                    <div class="section-title">
                        Accesos rápidos
                    </div>

                    <div class="section-subtitle mb-2">
                        Acciones frecuentes
                    </div>

                    <a href="{{ route('cursos.index') }}" class="quick-link">
                        <div class="quick-link-content">
                            <span class="quick-link-icon">
                                <i class="fa-solid fa-book-open"></i>
                            </span>
                            Ver cursos
                        </div>
                        <i class="fa-solid fa-chevron-right small"></i>
                    </a>

                    <a href="{{ route('usuarios.index') }}" class="quick-link">
                        <div class="quick-link-content">
                            <span class="quick-link-icon">
                                <i class="fa-solid fa-users"></i>
                            </span>
                            Gestionar usuarios
                        </div>
                        <i class="fa-solid fa-chevron-right small"></i>
                    </a>

                    <a href="{{ route('cursos.index') }}" class="quick-link">
                        <div class="quick-link-content">
                            <span class="quick-link-icon">
                                <i class="fa-solid fa-certificate"></i>
                            </span>
                            Certificados
                        </div>
                        <i class="fa-solid fa-chevron-right small"></i>
                    </a>

                </div>


                {{-- =================================================
                    RESUMEN
                ================================================== --}}

                <div class="dashboard-card p-3 p-lg-4">

                    <div class="section-title">
                        Resumen de la academia
                    </div>

                    <div class="section-subtitle mb-4">
                        Información general
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">
                            Usuarios registrados
                        </span>
                        <strong>
                            {{ $stats['total_estudiantes'] ?? 0 }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted small">
                            Cursos disponibles
                        </span>
                        <strong>
                            {{ $stats['total_cursos'] ?? 0 }}
                        </strong>
                    </div>

                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted small">
                            Certificados
                        </span>
                        <strong>
                            {{ \App\Models\Certificado::count() }}
                        </strong>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection