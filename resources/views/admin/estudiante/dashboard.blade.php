@extends('layouts.app')

@section('content')
<div class="container py-5">

    <!-- Encabezado corporativo moderno en modo oscuro -->
    <div class="row mb-5 align-items-center">
        <div class="col">
            <div class="d-inline-flex align-items-center bg-dark text-info border border-secondary px-3 py-1 rounded-pill fw-bold small mb-3 shadow-sm">
                <i class="fa-solid fa-graduation-cap me-2"></i> Ruta de Aprendizaje
            </div>
            <h1 class="fw-bold text-dark display-6 mb-2">
                ¡Hola, {{ auth()->user()->name }}! 
            </h1>
            <p class="text-secondary mb-0 fs-6">
                Explora todas las capacitaciones disponibles y descarga tu certificación oficial.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Pestañas de navegación -->
    <ul class="nav nav-pills mb-4 gap-2" id="studentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4 rounded-pill shadow-sm bg-primary text-white" id="cursos-tab" data-bs-toggle="pill" data-bs-target="#cursos-pane" type="button" role="tab">
                <i class="fa-solid fa-book-open me-2"></i> Mis Cursos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold px-4 rounded-pill bg-dark text-light border border-secondary shadow-sm" id="certificados-tab" data-bs-toggle="pill" data-bs-target="#certificados-pane" type="button" role="tab">
                <i class="fa-solid fa-award me-2 text-warning"></i> Certificación
            </button>
        </li>
    </ul>

    <div class="tab-content" id="studentTabsContent">
        
        <!-- PESTAÑA 1: CURSOS -->
        <div class="tab-pane fade show active" id="cursos-pane" role="tabpanel">
            <div class="row g-4">
                @foreach($cursos as $curso)
                    @php
                        $tieneCertificado = isset($certificados[$curso->id]);
                    @endphp

                    <div class="col-md-4">
                        <div class="card curso-card shadow-lg h-100 bg-dark text-white border-0 rounded-4 overflow-hidden d-flex flex-column">
                            
                            <!-- SECCIÓN SUPERIOR: foto del líder del área (se busca sola en public/imagenes) -->
                            <div class="position-relative w-100 bg-black" style="height: 220px; overflow: hidden;">
                                @php
                                    $urlLiderArea = $curso->area->foto_lider_url ?? null;
                                @endphp

                                @if($urlLiderArea)
                                    <img src="{{ $urlLiderArea }}"
                                         class="w-100 h-100"
                                         style="object-fit: cover; object-position: center;"
                                         alt="Líder del Área"
                                         onerror="this.style.display='none';">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background:#1f2937;">
                                        <i class="fa-solid fa-user-tie fa-3x text-secondary opacity-50"></i>
                                    </div>
                                @endif

                                <div class="position-absolute top-0 start-0 m-3 z-2">
                                    <span class="badge {{ $tieneCertificado ? 'bg-success' : 'bg-primary' }} rounded-pill px-3 py-2 shadow">
                                        {!! $tieneCertificado ? '✔ Completado' : '🚀 Disponible' !!}
                                    </span>
                                </div>
                            </div>

                            <!-- SECCIÓN INFERIOR -->
                            <div class="card-body d-flex flex-column justify-content-between p-4 bg-dark flex-grow-1">
                                <div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="small text-info fw-semibold uppercase tracking-wider">{{ $curso->area->nombre ?? 'Corporativo' }}</span>
                                    </div>
                                    <h4 class="fw-bold mb-2 text-white fs-5">
                                        {{ $curso->nombre }}
                                    </h4>
                                    <p class="small text-white-50 mb-4 lh-base text-truncate-3">
                                        {{ $curso->descripcion ?? 'Capacitación profesional interactiva corporativa.' }}
                                    </p>
                                </div>

                                <div class="d-grid gap-2">
                                    <a href="{{ route('estudiante.curso', $curso->id) }}" class="btn {{ $tieneCertificado ? 'btn-outline-light' : 'btn-primary' }} fw-bold rounded-pill py-2 shadow-sm">
                                        {!! $tieneCertificado ? 'Repasar Curso' : 'Continuar Curso <i class="fa-solid fa-arrow-right ms-1"></i>' !!}
                                    </a>

                                    @if($tieneCertificado)
                                        <a href="{{ route('certificados.descargar', $certificados[$curso->id]) }}" class="btn btn-success fw-bold rounded-pill py-2 shadow-sm">
                                            <i class="fa-solid fa-download me-1"></i> Descargar Certificación
                                        </a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- PESTAÑA 2: CERTIFICACIÓN -->
        <div class="tab-pane fade" id="certificados-pane" role="tabpanel">
            <div class="card shadow-lg border-0 bg-dark text-white rounded-4 p-4">
                <h4 class="fw-bold text-warning mb-2"><i class="fa-solid fa-award me-2"></i> Tu Certificación Oficial</h4>
                <p class="text-white-50 mb-4 small">Descarga tu diploma generado automáticamente con tus nombres tras completar satisfactoriamente las evaluaciones.</p>

                <div class="row g-3">
                    @forelse($certificados as $cursoId => $certId)
                        @php
                            $cursoCertificado = $cursos->where('id', $cursoId)->first();
                        @endphp
                        <div class="col-md-4">
                            <div class="p-4 bg-black border border-secondary rounded-4 text-center h-100 d-flex flex-column justify-content-between shadow-sm">
                                <div>
                                    <div class="text-warning mb-3">
                                        <i class="fa-solid fa-award fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold text-white mb-1 fs-6">{{ $cursoCertificado->nombre ?? 'Curso Completado' }}</h5>
                                    <p class="text-white-50 small mb-3">¡Aprobado con éxito por {{ auth()->user()->name }}!</p>
                                </div>
                                <a href="{{ route('certificados.descargar', $certId) }}" class="btn btn-success btn-sm rounded-pill px-4 fw-bold py-2 shadow-sm">
                                    <i class="fa-solid fa-download me-1"></i> Descargar Certificación
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-white-50">
                            <i class="fa-solid fa-folder-open fa-3x mb-3 opacity-50"></i>
                            <p class="mb-0">Aún no cuentas con certificaciones. ¡Termina y aprueba tus cursos para desbloquearlas!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>

<style>
    .curso-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .curso-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, 0.4) !important;
    }
    .text-truncate-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endsection