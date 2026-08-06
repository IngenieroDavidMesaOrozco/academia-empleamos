@extends('layouts.app')

@section('content')

<style>
    /* Efecto hover suave para las tarjetas de los módulos */
    .modulo-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .modulo-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
    .progress-bar {
        transition: width 1.5s ease-in-out;
    }
</style>

<div class="container py-4">

    <!-- Mensajes de éxito temporales -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" id="success-alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="mb-5 text-center">
        <h2 class="fw-bold text-primary mb-3">
            <i class="fa-solid fa-book-open me-2"></i>{{ $curso->nombre }}
        </h2>
        <p class="lead text-muted">
            {{ $curso->descripcion }}
        </p>
    </div>

    {{-- BARRA DE PROGRESO --}}
    <div class="card mb-5 shadow-sm border-0 bg-light">
        <div class="card-body p-4 text-center">
            <h5 class="fw-bold mb-3"><i class="fa-solid fa-chart-line me-2 text-success"></i>Tu Progreso</h5>
            <div class="progress rounded-pill mb-3" style="height:25px; background-color: #e9ecef;">
                <div class="progress-bar bg-success rounded-pill fw-bold fs-6" role="progressbar" style="width: 0%;" data-progress="{{ $porcentaje }}%">
                    {{ $porcentaje }}%
                </div>
            </div>
            <p class="text-muted mb-0">
                Has completado <strong class="text-dark">{{ $leccionesCompletadas }}</strong> de <strong class="text-dark">{{ $totalLecciones }}</strong> lecciones.
            </p>
        </div>
    </div>

    <h4 class="fw-bold mb-4">Contenido del Curso</h4>

    <div class="row">
        @foreach($curso->modulos as $modulo)

            <div class="col-12 mb-4">
                {{-- Bloquear módulos si el anterior no está terminado --}}
                @if(!$loop->first)
                    @php
                        $anterior = $curso->modulos[$loop->index-1];
                    @endphp

                    @if(!$modulosDesbloqueados[$anterior->id])
                        <div class="card shadow-sm border-0 opacity-75">
                            <div class="card-body p-4 text-center text-muted">
                                <i class="fa-solid fa-lock fa-3x mb-3 text-warning"></i>
                                <h5 class="fw-bold">Módulo Bloqueado</h5>
                                <p class="mb-0">Este módulo permanece bloqueado hasta completar al menos el 80% del módulo anterior ({{ $anterior->nombre }}).</p>
                            </div>
                        </div>
                        @continue
                    @endif
                @endif

                <div class="card shadow-sm border-0 modulo-card h-100">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
                        <h5 class="mb-0 fw-bold"><i class="fa-solid fa-layer-group me-2"></i>{{ $modulo->nombre }}</h5>
                        <span class="badge bg-light text-primary rounded-pill">{{ $modulo->lecciones->count() }} lecciones</span>
                    </div>

                    <div class="card-body p-4">
                        @if($modulo->descripcion)
                            <p class="text-muted mb-4">{{ $modulo->descripcion }}</p>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th width="50" class="text-center">#</th>
                                        <th>Lección</th>
                                        <th width="150" class="text-center">Estado</th>
                                        <th width="150" class="text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($modulo->lecciones as $leccion)
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="fw-semibold">{{ $leccion->titulo }}</span>
                                        </td>
                                        <td class="text-center">
                                            @if(in_array($leccion->id, $completadas))
                                                <span class="badge bg-success rounded-pill px-3 py-2"><i class="fa-solid fa-check me-1"></i> Completada</span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill px-3 py-2"><i class="fa-regular fa-clock me-1"></i> Pendiente</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('lecciones.show', $leccion->id) }}" class="btn btn-outline-primary btn-sm px-4 rounded-pill">
                                                <i class="fa-solid fa-play me-1"></i> Abrir
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{-- BOTÓN DE EVALUACIÓN DEL MÓDULO --}}
                        @if($modulo->evaluacion)
                            @php
                                $terminado = true;
                                foreach($modulo->lecciones as $lec){
                                    if(!in_array($lec->id, $completadas)){
                                        $terminado = false;
                                    }
                                }
                            @endphp

                            <hr class="my-4 text-muted">

                            <div class="text-center mt-3">
                                @if($terminado)
                                    <a href="{{ route('evaluacion.ver', $modulo->evaluacion->id) }}" class="btn btn-success btn-lg rounded-pill px-5 shadow-sm">
                                        <i class="fa-solid fa-pen-to-square me-2"></i> Presentar Evaluación
                                    </a>
                                @else
                                    <button class="btn btn-secondary btn-lg rounded-pill px-5 disabled">
                                        <i class="fa-solid fa-lock me-2"></i> Evaluación Bloqueada
                                    </button>
                                    <small class="d-block text-muted mt-2">Complete todas las lecciones del módulo para desbloquear.</small>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Auto-desaparecer alertas de éxito después de 4 segundos
        const alert = document.getElementById('success-alert');
        if (alert) {
            setTimeout(() => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 4000);
        }

        // Animar barra de progreso al cargar la página
        setTimeout(() => {
            const progressBar = document.querySelector('.progress-bar');
            if(progressBar) {
                const targetWidth = progressBar.getAttribute('data-progress');
                progressBar.style.width = targetWidth;
            }
        }, 300);
    });
</script>

@endsection
