@extends('layouts.app')

@section('content')

<!-- Estilos CSS de Alta Gama para la Plataforma de Estudio -->
<style>
    .hero-academia {
        background: linear-gradient(135deg, #0d1b2a 0%, #1b263b 50%, #415a77 100%);
        border: 1px solid rgba(255, 255, 255, 0.1);
        position: relative;
        overflow: hidden;
    }
    .hero-academia::after {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background: radial-gradient(circle at top right, rgba(13, 110, 253, 0.2), transparent 60%);
        pointer-events: none;
    }
    .etapa-modulo-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 1.25rem;
    }
    .etapa-modulo-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 1.25rem 2.5rem rgba(15, 23, 42, 0.08) !important;
        border-color: #cbd5e1;
    }
    .leccion-pill {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        transition: all 0.25s ease;
        border-radius: 1rem;
    }
    .leccion-pill:hover {
        background: #f1f5f9;
        border-color: #94a3b8;
        transform: translateX(6px);
    }
    .leccion-pill.completada {
        background: #f0fdf4;
        border-color: #86efac;
    }
    .progress-bar-custom {
        height: 12px;
        border-radius: 6px;
        background: rgba(255, 255, 255, 0.15);
    }
    .evaluacion-card-elite {
        background: linear-gradient(135deg, #f8fafc 0%, #ffffff 100%);
        border: 1px solid #e2e8f0;
        border-left: 6px solid #0d6efd !important;
        border-radius: 1rem;
        transition: all 0.3s ease;
    }
    .evaluacion-card-elite:hover {
        box-shadow: 0 0.5rem 1.5rem rgba(13, 110, 253, 0.08);
    }
</style>

<div class="container py-5">

    <!-- BOTON DE RETROCESO FLUIDO -->
    <div class="mb-4">
        <a href="{{ route('estudiante.dashboard') }}" class="btn btn-outline-secondary btn-sm px-4 py-2 rounded-pill shadow-sm d-inline-flex align-items-center fw-semibold text-decoration-none bg-white border-0 shadow-sm">
            <i class="fa-solid fa-arrow-left me-2 text-primary"></i> Volver a mi panel de ruta
        </a>
    </div>

    <!-- HERO SECTION DE LA CAPACITACION -->
    <div class="hero-academia rounded-5 p-4 p-md-5 mb-5 shadow-lg text-white position-relative">
        <div class="row align-items-center g-4">
            <div class="col-lg-8">
                <div class="d-inline-flex align-items-center bg-primary bg-opacity-25 text-info border border-primary border-opacity-50 px-3 py-1 rounded-pill fw-bold small mb-3">
                    <i class="fa-solid fa-graduation-cap me-2"></i> Academia Corporativa Empleamos
                </div>
                
                <h1 class="fw-bold display-5 mb-3 text-white tracking-tight">
                    {{ $curso->nombre }}
                </h1>
                
                <p class="text-white-50 fs-6 lh-lg mb-4" style="max-width: 800px;">
                    {{ $curso->descripcion }}
                </p>

                <!-- BARRA DE PROGRESO GENERAL DEL CURSO -->
                @php
                    $totalLeccionesCurso = 0;
                    $totalCompletadasCurso = 0;
                    foreach($curso->modulos as $mod) {
                        foreach($mod->lecciones as $lec) {
                            $totalLeccionesCurso++;
                            if(in_array($lec->id, $completadas)) {
                                $totalCompletadasCurso++;
                            }
                        }
                    }
                    $porcentajeCurso = $totalLeccionesCurso > 0 ? round(($totalCompletadasCurso / $totalLeccionesCurso) * 100) : 0;
                @endphp

                <div class="bg-black bg-opacity-30 p-3.5 rounded-4 border border-secondary border-opacity-25" style="max-width: 480px;">
                    <div class="d-flex justify-content-between align-items-center mb-2 small fw-semibold">
                        <span class="text-white-50"><i class="fa-solid fa-chart-line text-success me-1"></i> Progreso General</span>
                        <span class="text-info fw-bold">{{ $porcentajeCurso }}% Completado</span>
                    </div>
                    <div class="progress progress-bar-custom overflow-hidden shadow-inner">
                        <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" role="progressbar" style="width: {{ $porcentajeCurso }}%;" aria-valuenow="{{ $porcentajeCurso }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <!-- CARRUSEL CON LAS FOTOS DEL EQUIPO COMPLETO A LA DERECHA (CORREGIDO) -->
            @if(!empty($curso->fotos_equipo) && count($curso->fotos_equipo) > 0)
                <div class="col-lg-4 text-center">
                    <div class="card bg-black bg-opacity-40 border border-secondary border-opacity-50 shadow-lg rounded-4 p-3 d-inline-block backdrop-blur">
                        <span class="d-block text-info small fw-bold mb-2"><i class="fa-solid fa-users me-1"></i> Equipo de Trabajo</span>
                        
                        @if(count($curso->fotos_equipo) == 1)
                            @php
                                $rutaUnica = str_replace('public/', '', $curso->fotos_equipo[0]);
                                $urlUnica = Str::startsWith($rutaUnica, 'storage/') ? asset($rutaUnica) : asset('storage/' . $rutaUnica);
                            @endphp
                            <img src="{{ $urlUnica }}" alt="Equipo" class="rounded-3 shadow" style="height: 200px; width: 200px; object-fit: cover;">
                        @else
                            <div id="carouselHeroEquipo" class="carousel slide shadow rounded-3 overflow-hidden" data-bs-ride="carousel" data-bs-interval="3500" style="max-width: 200px; margin: 0 auto;">
                                <div class="carousel-inner">
                                    @foreach($curso->fotos_equipo as $index => $foto)
                                        @php
                                            $rutaItem = str_replace('public/', '', $foto);
                                            $urlItem = Str::startsWith($rutaItem, 'storage/') ? asset($rutaItem) : asset('storage/' . $rutaItem);
                                        @endphp
                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ $urlItem }}" class="rounded-3 shadow w-100" alt="Equipo" style="height: 200px; object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- SECCION DE ETAPAS / MODULOS INTERACTIVOS -->
    <div class="mb-4 d-flex align-items-center justify-content-between">
        <h3 class="fw-bold text-dark mb-0"><i class="fa-solid fa-layer-group text-primary me-2"></i> Etapas y Modulos de Estudio</h3>
        <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-bold">
            {{ $curso->modulos->count() }} Modulos Disponibles
        </span>
    </div>

    <div class="row g-4">
        @foreach($curso->modulos as $modulo)

            {{-- Validacion de Bloqueo Secuencial --}}
            @php
                $bloqueadoModulo = false;
                if(!$loop->first) {
                    $anterior = $curso->modulos[$loop->index-1];
                    if(!$modulosDesbloqueados[$anterior->id]) {
                        $bloqueadoModulo = true;
                    }
                }
            @endphp

            <div class="col-12">
                <div class="etapa-modulo-card shadow-sm p-4 p-md-5 position-relative {{ $bloqueadoModulo ? 'opacity-75 bg-light' : '' }}">
                    
                    @if($bloqueadoModulo)
                        <!-- Capa de bloqueo elegante -->
                        <div class="position-absolute top-0 start-0 w-100 h-100 bg-white bg-opacity-75 rounded-4 d-flex align-items-center justify-content-center z-2">
                            <div class="text-center p-4">
                                <div class="text-secondary mb-2 fs-2"><i class="fa-solid fa-lock"></i></div>
                                <h5 class="fw-bold text-dark">Modulo Bloqueado</h5>
                                <p class="text-muted small mb-0">Debes completar el modulo anterior y aprobar su evaluacion para desbloquear esta etapa.</p>
                            </div>
                        </div>
                    @endif

                    <!-- Cabecera del Modulo -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center pb-4 mb-4 border-bottom gap-3">
                        <div>
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <span class="badge bg-primary text-white px-3 py-1 rounded-pill fw-bold">Modulo 0{{ $loop->iteration }}</span>
                                <span class="text-muted small fw-semibold"><i class="fa-solid fa-book-bookmark me-1 text-primary"></i> {{ $modulo->lecciones->count() }} Lecciones interactivas</span>
                            </div>
                            <h3 class="fw-bold text-dark fs-3 mb-0">{{ $modulo->nombre }}</h3>
                        </div>

                        @if($modulo->descripcion)
                            <div class="text-secondary small max-w-md" style="max-width: 400px;">
                                {{ $modulo->descripcion }}
                            </div>
                        @endif
                    </div>

                    <!-- Listado de Lecciones Estilo Tarjetas Grid -->
                    <div class="row g-3 mb-4">
                        @foreach($modulo->lecciones as $leccion)
                            @php
                                $completada = in_array($leccion->id, $completadas);
                            @endphp
                            <div class="col-md-6">
                                <div class="leccion-pill p-3.5 d-flex justify-content-between align-items-center {{ $completada ? 'completada' : '' }}">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle {{ $completada ? 'bg-success text-white' : 'bg-primary bg-opacity-10 text-primary' }} fw-bold d-flex justify-content-center align-items-center shadow-sm" style="width: 42px; height: 42px; min-width: 42px;">
                                            @if($completada)
                                                <i class="fa-solid fa-check"></i>
                                            @else
                                                {{ $loop->iteration }}
                                            @endif
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-0 fs-6">{{ $leccion->titulo }}</h6>
                                            <small class="{{ $completada ? 'text-success fw-bold' : 'text-muted' }}">
                                                {!! $completada ? 'Leccion superada' : 'Lectura y recursos web' !!}
                                            </small>
                                        </div>
                                    </div>

                                    <div>
                                        <a href="{{ route('lecciones.show', $leccion->id) }}" class="btn {{ $completada ? 'btn-outline-success' : 'btn-primary' }} btn-sm px-3.5 py-2 rounded-pill fw-semibold shadow-sm text-decoration-none">
                                            {{ $completada ? 'Repasar' : 'Estudiar' }} <i class="fa-solid fa-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- BLOQUE DE EVALUACION DE LA ETAPA -->
                    @if($modulo->evaluacion)
                        @php
                            $terminado = true;
                            foreach($modulo->lecciones as $lec) {
                                if(!in_array($lec->id, $completadas)) {
                                    $terminado = false;
                                }
                            }
                        @endphp

                        <div class="evaluacion-card-elite p-4 p-md-4 shadow-sm d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mt-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center fs-4 shadow-sm" style="width: 52px; height: 52px; min-width: 52px;">
                                    <i class="fa-solid fa-award"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-1">Validacion de Conocimiento (Evaluacion)</h5>
                                    <p class="text-secondary small mb-0">Demuestra lo aprendido en este modulo para avanzar en tu ruta corporativa.</p>
                                </div>
                            </div>

                            <div>
                                @if($terminado)
                                    <a href="{{ route('evaluacion.ver', $modulo->evaluacion->id) }}" class="btn btn-primary fw-bold px-4 py-2.5 rounded-pill shadow-sm">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Presentar Examen
                                    </a>
                                @else
                                    <button class="btn btn-outline-secondary px-4 py-2.5 rounded-pill fw-semibold border-0 bg-light text-muted" disabled>
                                        <i class="fa-solid fa-lock me-1"></i> Completa las lecciones primero
                                    </button>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>

        @endforeach
    </div>

</div>

@endsection