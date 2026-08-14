@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Encabezado amigable y dinámico -->
    <div class="row mb-4 align-items-center">
        <div class="col">
            <h2 class="fw-bold text-white mb-1">
                🎓 ¡Hola, {{ auth()->user()->name }}! Tu Ruta de Aprendizaje
            </h2>
            <p class="text-muted mb-0">Completa cada curso en orden estricto para desbloquear el siguiente nivel y obtener tus certificados.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Pestañas de navegación amigables -->
    <ul class="nav nav-pills mb-4 gap-2" id="studentTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold px-4 rounded-pill" id="cursos-tab" data-bs-toggle="pill" data-bs-target="#cursos-pane" type="button" role="tab">
                📚 Mis Cursos
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold px-4 rounded-pill bg-dark text-white border border-secondary" id="certificados-tab" data-bs-toggle="pill" data-bs-target="#certificados-pane" type="button" role="tab">
                🏆 Mis Certificados
            </button>
        </li>
    </ul>

    <div class="tab-content" id="studentTabsContent">
        
        <!-- PESTAÑA 1: CURSOS CON BLOQUEO SECUENCIAL ESTRICTO -->
        <div class="tab-pane fade show active" id="cursos-pane" role="tabpanel">
            <div class="row">
                @php
                    $cursoAnteriorCompletado = true; // El primer curso siempre está disponible de entrada
                @endphp

                @foreach($cursos as $curso)
                    @php
                        $tieneCertificado = isset($certificados[$curso->id]);
                        // El curso actual se bloquea si el curso anterior NO tiene certificado (no está completado)
                        $bloqueado = !$cursoAnteriorCompletado;
                    @endphp

                    <div class="col-md-4 mb-4">
                        <div class="card shadow h-100 {{ $bloqueado ? 'bg-black text-muted opacity-50 border border-secondary' : 'bg-dark text-white border-0' }} rounded-4 overflow-hidden">
                            
                            <div class="card-header bg-transparent border-0 pt-3 pb-0 d-flex justify-content-between align-items-center">
                                <span class="badge {{ $tieneCertificado ? 'bg-success' : ($bloqueado ? 'bg-secondary' : 'bg-primary') }} rounded-pill px-3">
                                    {{ $tieneCertificado ? '✅ Completado' : ($bloqueado ? '🔒 Bloqueado' : '🔥 En Progreso') }}
                                </span>
                                <small class="text-muted">Módulos: {{ $curso->modulos->count() }}</small>
                            </div>

                            <div class="card-body d-flex flex-column justify-content-between p-4">
                                <div>
                                    <h4 class="fw-bold mb-2 {{ $bloqueado ? 'text-muted' : 'text-white' }}">
                                        {{ $curso->nombre }}
                                    </h4>
                                    <p class="small text-muted mb-4">
                                        {{ $curso->descripcion ?? 'Capacitación profesional interactiva.' }}
                                    </p>
                                </div>

                                <div>
                                    @if($bloqueado)
                                        <button class="btn btn-outline-secondary w-100 rounded-pill py-2 disabled" style="font-size: 0.85rem;">
                                            <i class="fa-solid fa-lock me-1"></i> Completa el curso anterior para desbloquear
                                        </button>
                                    @else
                                        <a href="{{ route('estudiante.curso', $curso->id) }}" class="btn {{ $tieneCertificado ? 'btn-outline-success' : 'btn-primary' }} w-100 fw-bold rounded-pill py-2 shadow-sm mb-2">
                                            📖 {{ $tieneCertificado ? 'Repasar Curso' : 'Continuar Curso 🚀' }}
                                        </a>
                                    @endif

                                    @if($tieneCertificado)
                                        <a href="{{ route('certificados.descargar', $certificados[$curso->id]) }}" class="btn btn-success w-100 fw-bold rounded-pill py-2 shadow-sm">
                                            🎓 Descargar Certificado
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        // Actualizamos la regla: para que el siguiente ciclo libere el curso sucesor, este curso actual debe estar certificado
                        $cursoAnteriorCompletado = $tieneCertificado;
                    @endphp
                @endforeach
            </div>
        </div>

        <!-- PESTAÑA 2: CERTIFICADOS Y LOGROS -->
        <div class="tab-pane fade" id="certificados-pane" role="tabpanel">
            <div class="card shadow border-0 bg-dark text-white rounded-4 p-4">
                <h4 class="fw-bold text-warning mb-3">🏆 Tus Diplomas Obtenidos</h4>
                <p class="text-muted mb-4">Aquí se listan todos los certificados oficiales generados al completar satisfactoriamente tus evaluaciones.</p>

                <div class="row">
                    @forelse($certificados as $cursoId => $certId)
                        @php
                            $cursoCertificado = $cursos->where('id', $cursoId)->first();
                        @endphp
                        <div class="col-md-4 mb-3">
                            <div class="p-3 bg-black border border-secondary rounded-4 text-center">
                                <i class="fa-solid fa-award text-warning fa-3x mb-2"></i>
                                <h5 class="fw-bold text-white mb-1">{{ $cursoCertificado->nombre ?? 'Curso Completado' }}</h5>
                                <p class="text-muted small mb-3">¡Aprobado con éxito!</p>
                                <a href="{{ route('certificados.descargar', $certId) }}" class="btn btn-success btn-sm rounded-pill px-4 fw-bold">
                                    <i class="fa-solid fa-download me-1"></i> Descargar Diploma
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-4 text-muted">
                            <p class="mb-0">Aún no tienes certificados. ¡Termina y aprueba tu primer curso para desbloquear tu diploma!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

</div>
@endsection

<div>
    
</div>