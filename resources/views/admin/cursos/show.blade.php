@extends('layouts.app')

@section('content')

<div class="container py-5">

    <!-- BOTÓN DE REGRESO MODERNO -->
    <div class="mb-4">
        <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary btn-sm px-4 py-2 rounded-pill shadow-sm d-inline-flex align-items-center fw-semibold text-decoration-none bg-white">
            <i class="fa-solid fa-arrow-left me-2 text-primary"></i> Volver al listado de cursos
        </a>
    </div>

    <!-- ENCABEZADO Y DESCRIPCIÓN DEL CURSO -->
    <div class="card border-0 shadow-lg rounded-4 p-4 p-md-5 mb-5 text-white" style="background: linear-gradient(135deg, #0b0f19 0%, #1a2238 100%);">
        <div class="d-flex align-items-center mb-3">
            <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold small">
                <i class="fa-solid fa-shield-halved me-1"></i> Panel de Administración - Vista de Curso
            </span>
        </div>
        
        <h1 class="fw-bold display-5 mb-3 text-white">
            {{ $curso->nombre }}
        </h1>
        
        <p class="text-white-50 fs-6 lh-lg mb-0" style="max-width: 900px;">
            {{ $curso->descripcion }}
        </p>
    </div>

    <!-- BLOQUE INTELIGENTE: FOTOS DEL EQUIPO / PORTADA -->
    @php $fotosUrls = $curso->fotos_urls; @endphp
    @if(count($fotosUrls) > 0)
        <div class="d-flex justify-content-center mb-5">
            <div class="card bg-dark border-0 shadow-lg rounded-4 p-4 text-white" style="width: fit-content; max-width: 100%;">
                <h5 class="fw-bold text-info mb-3 text-center">
                    <i class="fa-solid fa-users me-2"></i> Nuestro Equipo
                </h5>

                @if(count($fotosUrls) == 1)
                    <div class="text-center rounded-4 overflow-hidden" style="max-height: 450px;">
                        <img src="{{ $fotosUrls[0] }}" alt="Portada del curso" class="rounded-4 shadow-sm" style="max-height: 450px; width: auto; max-width: 100%; height: auto; display: block; margin: 0 auto; object-fit: contain;">
                    </div>
                @else
                    <div id="carouselEquipoCurso" class="carousel slide shadow rounded-4 overflow-hidden" data-bs-ride="carousel" data-bs-interval="4000" style="max-width: 450px; margin: 0 auto;">
                        <div class="carousel-indicators">
                            @foreach($fotosUrls as $index => $url)
                                <button type="button" data-bs-target="#carouselEquipoCurso" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                            @endforeach
                        </div>

                        <div class="carousel-inner text-center">
                            @foreach($fotosUrls as $index => $url)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ $url }}" class="rounded-4 shadow-sm" alt="Foto del equipo" style="max-height: 450px; width: auto; max-width: 100%; height: auto; display: block; margin: 0 auto; object-fit: contain;">
                                </div>
                            @endforeach
                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselEquipoCurso" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon bg-dark rounded-circle p-3 shadow" aria-hidden="true" style="width: 2.5rem; height: 2.5rem;"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselEquipoCurso" data-bs-slide="next">
                            <span class="carousel-control-next-icon bg-dark rounded-circle p-3 shadow" aria-hidden="true" style="width: 2.5rem; height: 2.5rem;"></span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- CONTENEDOR DE MÓDULOS Y LECCIONES -->
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-4"><i class="fa-solid fa-layer-group text-primary me-2"></i> Módulos y Secciones Configuradas</h3>
    </div>

    @foreach($curso->modulos as $modulo)

        <div class="card mb-4 border-0 shadow-sm rounded-4 overflow-hidden bg-white">

            <div class="card-header bg-white border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
                <div>
                    <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold small mb-1">
                        Módulo #{{ $loop->iteration }}
                    </span>
                    <h4 class="mb-0 fw-bold text-dark fs-5">{{ $modulo->nombre }}</h4>
                </div>
                <div class="text-muted small fw-semibold">
                    <i class="fa-solid fa-book-open me-1 text-primary"></i> {{ $modulo->lecciones->count() }} Lección(es)
                </div>
            </div>

            <div class="card-body p-4">

                @if($modulo->descripcion)
                    <p class="text-secondary mb-3">{{ $modulo->descripcion }}</p>
                @endif

                <div class="d-flex flex-column gap-3">
                    @foreach($modulo->lecciones as $leccion)
                        <div class="p-3 rounded-3 border d-flex justify-content-between align-items-center bg-light shadow-sm">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary fw-bold d-flex justify-content-center align-items-center me-3" style="width: 38px; height: 38px; min-width: 38px;">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0 fs-6">{{ $leccion->titulo }}</h6>
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('lecciones.show', $leccion->id) }}" class="btn btn-primary btn-sm px-4 rounded-pill fw-semibold shadow-sm text-decoration-none">
                                    <i class="fa-solid fa-eye me-1"></i> Ver Lección
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- EVALUACIÓN CONFIGURADA --}}
                @if($modulo->evaluacion)
                    <div class="mt-4 pt-3 border-top d-flex justify-content-between align-items-center bg-white p-3 rounded-3 border">
                        <div>
                            <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clipboard-question text-primary me-2"></i> Evaluación del Módulo: {{ $modulo->evaluacion->titulo ?? 'Examen Asociado' }}</h6>
                            <small class="text-muted">Cuestionario de validación configurado correctamente.</small>
                        </div>

                        <div>
                            <a href="{{ route('evaluacion.ver', $modulo->evaluacion->id) }}" class="btn btn-outline-primary px-4 rounded-pill fw-semibold shadow-sm text-decoration-none">
                                <i class="fa-solid fa-file-lines me-1"></i> Revisar Examen
                            </a>
                        </div>
                    </div>
                @endif

            </div>

        </div>

    @endforeach

</div>

@endsection