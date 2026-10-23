@extends('layouts.app')

@section('page-title', 'Cursos Disponibles')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-5 flex-wrap gap-3">
        <div>
            <div class="d-inline-flex align-items-center bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill fw-bold small mb-2">
                <i class="fa-solid fa-layer-group me-2"></i>
                Gestión de Capacitaciones
            </div>

            <h2 class="fw-bold text-dark display-6 mb-1">
                Cursos Disponibles
            </h2>

            <p class="text-secondary mb-0">
                Administra, edita o explora las capacitaciones corporativas de la plataforma.
            </p>
        </div>

        <a href="{{ route('cursos.create') }}"
           class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
            <i class="fa-solid fa-plus me-2"></i>
            Nuevo Curso
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-4 mb-4" role="alert">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="row g-4">

        @forelse($cursos as $curso)
            <div class="col-md-4 col-sm-6">
                <div class="card curso-card border-0 shadow-lg rounded-4 overflow-hidden position-relative bg-dark"
                     style="height: 380px;">

                    {{-- Imagen principal del curso limpia y automatizada --}}
                    <div class="position-absolute top-0 start-0 w-100 h-100">
                        @php
                            // Mapeo directo por nombre del curso
                            $imagenesPorNombre = [
                                'Tesorería' => 'Personal/MariaCamilaPineda.png',
                                'Seguridad y Salud en el Trabajo (SST)' => 'Personal/ClaudiaRoldan.png',
                                'Tecnología y Sistemas (TI)' => "Personal\yefreymosquera.png",
                                'Recepción y Gestión de Solicitudes' => "Personal\Diana Carolina Lopez.png",
                                'Nómina y Gestión Financiera' => 'Personal/Juanestebanarenas.png',
                            ];

                            // Obtiene la ruta del mapeo o busca directamente en la propiedad del curso
                            $rutaFotoRelativa = $imagenesPorNombre[$curso->nombre] ?? ($curso->fotos_equipo[0] ?? null);
                            
                            // Construye la URL final de forma limpia y segura
                            if ($rutaFotoRelativa) {
                                $limpia = str_replace('imagenes/', '', ltrim($rutaFotoRelativa, '/'));
                                $imagenFinal = asset('imagenes/' . $limpia);
                            } else {
                                $imagenFinal = asset("imagenes/ContenidoCurso/logo-empleamos-job.png");
                            }
                        @endphp

                        <img
                            src="{{ $imagenFinal }}"
                            onerror="this.onerror=null; this.src='{{ asset("imagenes/ContenidoCurso/logo-empleamos-job.png") }}';"
                            class="d-block w-100 h-100 object-fit-cover"
                            alt="Imagen de {{ $curso->nombre }}">
                    </div>

                    {{-- Degradado para facilitar la lectura --}}
                    <div class="position-absolute top-0 start-0 w-100 h-100"
                         style="background: linear-gradient(to top, rgba(11,15,25,.92) 0%, rgba(11,15,25,.25) 55%, rgba(11,15,25,.10) 100%);">
                    </div>

                    {{-- Información y acciones --}}
                    <div class="card-body d-flex flex-column justify-content-between position-absolute top-0 start-0 w-100 h-100 p-4 text-white"
                         style="z-index: 2;">

                        <div>
                            <span class="badge bg-dark bg-opacity-75 text-white px-3 py-2 rounded-pill shadow-sm">
                                {{ $curso->area->nombre ?? 'Corporativo' }}
                            </span>
                        </div>

                        <div class="mt-auto">

                            <h5 class="fw-bold text-white mb-2">
                                {{ $curso->nombre }}
                            </h5>

                            <p class="small text-white-50 mb-3">
                                {{ \Illuminate\Support\Str::limit($curso->descripcion, 90) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">

                                <small class="fw-bold">
                                    @if($curso->estado)
                                        <span class="text-success">● Activo</span>
                                    @else
                                        <span class="text-warning">● Inactivo</span>
                                    @endif
                                </small>

                                <div class="d-flex align-items-center gap-2">

                                    <a href="{{ route('cursos.edit', $curso) }}"
                                       class="btn btn-sm btn-light text-dark fw-bold rounded-pill px-3">
                                        <i class="fa-solid fa-pen me-1"></i>
                                        Editar
                                    </a>

                                    <form action="{{ route('cursos.destroy', $curso->id) }}"
                                          method="POST"
                                          class="d-inline form-eliminar">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger rounded-circle d-flex align-items-center justify-content-center"
                                                style="width: 34px; height: 34px;"
                                                title="Eliminar curso"
                                                aria-label="Eliminar curso">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Enlace a los detalles del curso --}}
                    <a href="{{ route('cursos.show', $curso->id) }}"
                       class="position-absolute top-0 start-0 w-100 h-100"
                       style="z-index: 1;"
                       aria-label="Ver {{ $curso->nombre }}"></a>

                </div>
            </div>

        @empty
            <div class="col-12">
                <div class="text-center text-muted py-5">
                    <i class="fa-solid fa-folder-open mb-3 text-secondary fs-1"></i>
                    <p class="mb-0 fs-5">
                        No existen cursos registrados actualmente.
                    </p>
                </div>
            </div>
        @endforelse

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.form-eliminar').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: '¿Estás seguro?',
                text: 'Esta acción eliminará el curso. Verifica antes de continuar.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar',
                reverseButtons: true
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

<style>
.curso-card {
    transition: transform .3s ease, box-shadow .3s ease;
}

.curso-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 1rem 2.5rem rgba(0, 0, 0, .3) !important;
}

.object-fit-cover {
    object-fit: cover;
}
</style>
@endsection