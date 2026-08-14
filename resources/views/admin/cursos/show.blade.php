@extends('layouts.app')

@section('page-title', 'Centro de Mando del Curso')

@section('content')
<div class="container-fluid px-0">

    <!-- Encabezado del Centro de Mando -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('cursos.index') }}">Cursos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Centro de Mando</li>
                </ol>
            </nav>
            <span class="badge bg-primary mb-2 mt-1">{{ $curso->area->nombre ?? 'Sin área' }}</span>
            <h2 class="fw-bold mb-0 text-primary">{{ $curso->nombre }}</h2>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('cursos.edit', $curso->id) }}" class="btn btn-outline-primary btn-sm">
                <i class="fa-solid fa-pen me-1"></i> Editar Curso
            </a>
            <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa-solid fa-arrow-left me-1"></i> Volver a Cursos
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Pestañas de Navegación -->
    <ul class="nav nav-tabs mb-4" id="cursoTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-semibold" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-pane" type="button" role="tab">
                <i class="fa-solid fa-circle-info me-2"></i> Información General
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="contenido-tab" data-bs-toggle="tab" data-bs-target="#contenido-pane" type="button" role="tab">
                <i class="fa-solid fa-layer-group me-2"></i> Módulos y Lecciones
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-semibold" id="evaluacion-tab" data-bs-toggle="tab" data-bs-target="#evaluacion-pane" type="button" role="tab">
                <i class="fa-solid fa-clipboard-question me-2"></i> Evaluaciones
            </button>
        </li>
    </ul>

    <!-- Contenido de las Pestañas -->
    <div class="tab-content" id="cursoTabContent">
        
        <!-- PESTAÑA 1: INFORMACIÓN GENERAL -->
        <div class="tab-pane fade show active" id="info-pane" role="tabpanel" tabindex="0">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-3">Detalles de la Capacitación</h5>
                <div class="row g-3">
                    <div class="col-md-6 mb-3">
                        <span class="text-muted small d-block uppercase fw-semibold">Estado del Curso</span>
                        <span class="badge {{ $curso->estado == 1 || $curso->estado == 'activo' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }} px-3 py-2 mt-1">
                            {{ $curso->estado == 1 || $curso->estado == 'activo' ? 'ACTIVO' : 'INACTIVO' }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-3">
                        <span class="text-muted small d-block uppercase fw-semibold">Área Asignada</span>
                        <p class="text-body mt-1 fw-semibold">{{ $curso->area->nombre ?? 'Sin área asignada' }}</p>
                    </div>
                    <div class="col-12 mb-3">
                        <span class="text-muted small d-block uppercase fw-semibold">Descripción</span>
                        <p class="text-body mt-1">{{ $curso->descripcion ?? 'Sin descripción registrada.' }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <span class="text-muted small d-block uppercase fw-semibold">Fecha de Creación</span>
                        <p class="text-body mt-1">{{ $curso->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- PESTAÑA 2: MÓDULOS Y LECCIONES -->
        <div class="tab-pane fade" id="contenido-pane" role="tabpanel" tabindex="0">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-3">Estructura del Contenido</h5>

                @forelse($curso->modulos as $modulo)
                    <div class="card border mb-3 bg-body">
                        <div class="card-header bg-transparent fw-bold d-flex justify-content-between align-items-center">
                            <span><i class="fa-solid fa-folder-open text-primary me-2"></i> {{ $modulo->nombre }}</span>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                @forelse($modulo->lecciones as $leccion)
                                    <li class="list-group-item bg-transparent d-flex justify-content-between align-items-center">
                                        <span><i class="fa-solid fa-file-lines text-muted me-2"></i> {{ $leccion->titulo }}</span>
                                    </li>
                                @empty
                                    <li class="list-group-item bg-transparent text-muted small">No hay lecciones en este módulo.</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fa-solid fa-folder-open fa-2x mb-2 d-block"></i>
                        <p class="mb-0">Este curso aún no tiene módulos registrados.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- PESTAÑA 3: EVALUACIONES -->
        <div class="tab-pane fade" id="evaluacion-pane" role="tabpanel" tabindex="0">
            <div class="card shadow-sm border-0 p-4">
                <h5 class="fw-bold mb-3">Exámenes y Preguntas</h5>

                @php
                    $evaluaciones = $curso->modulos ? $curso->modulos->flatMap->evaluaciones : collect();
                @endphp

                @forelse($evaluaciones as $evaluacion)
                    <div class="card border mb-3 bg-body">
                        <div class="card-header bg-transparent fw-bold">
                            <i class="fa-solid fa-clipboard-question text-warning me-2"></i> {{ $evaluacion->titulo }}
                        </div>
                        <div class="card-body">
                            <ol class="mb-0">
                                @foreach($evaluacion->preguntas as $pregunta)
                                    <li class="mb-3">
                                        <span class="fw-semibold">{{ $pregunta->pregunta }}</span>
                                        <ul class="mt-2 list-unstyled ps-3">
                                            @foreach($pregunta->opciones as $opcion)
                                                <li class="small mb-1 {{ $opcion->es_correcta ? 'text-success fw-bold' : 'text-muted' }}">
                                                    <i class="fa-solid {{ $opcion->es_correcta ? 'fa-check-circle' : 'fa-circle' }} me-1"></i>
                                                    {{ $opcion->opcion }}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4 text-muted">
                        <i class="fa-solid fa-clipboard-question fa-2x mb-2 d-block"></i>
                        <p class="mb-0">Este curso no cuenta con evaluaciones registradas.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection