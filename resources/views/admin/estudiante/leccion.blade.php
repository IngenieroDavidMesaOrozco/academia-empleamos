@extends('layouts.app')

@section('content')
<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-3 shadow-sm rounded-pill px-4">
        <i class="fa-solid fa-arrow-left me-1 text-primary"></i> Volver
    </a>

    <div class="card shadow-lg border-0 bg-dark text-white rounded-4 overflow-hidden">

        <div class="card-header bg-primary text-white p-4 border-0 d-flex justify-content-between align-items-center">
            <h3 class="mb-0 fw-bold fs-4">
                <i class="fa-solid fa-book-open-reader me-2"></i>
                {{ $leccion->titulo }}
            </h3>
        </div>

        <div class="card-body p-4 p-md-5">

            <h5 class="text-info fw-semibold mb-2">Descripción</h5>

            <p class="text-light lh-lg mb-4">
                {{ $leccion->descripcion }}
            </p>

            @if($leccion->video)
                <hr class="border-secondary my-4">

                <h5 class="text-warning fw-semibold mb-3">Video de Apoyo</h5>

                <div class="ratio ratio-16x9 rounded-4 overflow-hidden border border-secondary shadow-sm">
                    <iframe src="{{ $leccion->video }}" allowfullscreen></iframe>
                </div>
            @endif

            <hr class="border-secondary my-4">

            <div class="mb-4">

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="text-success fw-semibold mb-0">
                        <i class="fa-solid fa-presentation-screen me-2"></i>
                        Material Interactivo y Archivos
                    </h5>
                </div>

                @php
                    $recursos = $leccion->recursos ?? ($leccion->contenido ?? collect());
                    if ($recursos instanceof \Illuminate\Database\Eloquent\Collection && $recursos->isEmpty() && isset($leccion->contenidos)) {
                        $recursos = $leccion->contenidos;
                    }

                    // Función blindada para resolver la URL sin importar nombres cifrados o originales
                    $obtenerUrlSegura = function ($archivo) {
                        if (empty($archivo)) {
                            return null;
                        }

                        $nombreArchivo = basename(str_replace('\\', '/', $archivo));

                        // 1. Buscar directamente en la carpeta física public/imagenes/ContenidoCurso
                        $rutaFisica = public_path('imagenes/ContenidoCurso/' . $nombreArchivo);
                        if (is_file($rutaFisica)) {
                            return asset('imagenes/ContenidoCurso/' . $nombreArchivo);
                        }

                        // 2. Buscar en minúsculas por si acaso
                        $rutaFisicaLower = public_path('imagenes/contenidocurso/' . $nombreArchivo);
                        if (is_file($rutaFisicaLower)) {
                            return asset('imagenes/contenidocurso/' . $nombreArchivo);
                        }

                        // 3. Buscar de manera flexible en public/imagenes/
                        if (is_file(public_path('imagenes/' . $nombreArchivo))) {
                            return asset('imagenes/' . $nombreArchivo);
                        }

                        // 4. Si falló todo lo anterior, armar la ruta directa por defecto
                        return asset('imagenes/ContenidoCurso/' . $nombreArchivo);
                    };
                @endphp

                @if($recursos->count() > 0)

                    <div id="carruselRecursosLeccion" class="carousel slide" data-bs-ride="carousel">

                        <div class="carousel-inner rounded-4 border border-secondary bg-black p-3">

                            @foreach($recursos as $key => $recurso)

                                @php
                                    $pathArchivo = $recurso->archivo ?? ($recurso->url ?? ($recurso->path ?? ''));
                                    $nombreItem = $recurso->nombre ?? ($recurso->titulo ?? 'Recurso');
                                    
                                    $extension = strtolower(pathinfo($pathArchivo, PATHINFO_EXTENSION));
                                    $esImagen = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif', 'avif']);
                                    $urlRecurso = $obtenerUrlSegura($pathArchivo);
                                @endphp

                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">

                                    <div class="text-center p-3 d-flex flex-column justify-content-center align-items-center"
                                         style="min-height: 450px;">

                                        @if($esImagen && $urlRecurso)

                                            <img src="{{ $urlRecurso }}"
                                                 class="img-fluid rounded-3 shadow mb-3"
                                                 style="max-height: 70vh; object-fit: contain;"
                                                 alt="{{ $nombreItem }}"
                                                 onerror="this.onerror=null; this.src='{{ asset('imagenes/ContenidoCurso/' . basename($pathArchivo)) }}';">

                                        @else

                                            <div class="py-5 text-warning">
                                                <i class="fa-solid fa-file-arrow-down display-1 mb-3"></i>
                                                <p class="text-light fw-bold">
                                                    {{ $nombreItem }}
                                                </p>
                                            </div>

                                        @endif

                                        <div class="mt-2">

                                            <span class="badge bg-primary px-3 py-2 rounded-pill fs-6">
                                                {{ $nombreItem }}
                                            </span>

                                            @if($urlRecurso)
                                                <a href="{{ $urlRecurso }}"
                                                   target="_blank"
                                                   rel="noopener noreferrer"
                                                   class="btn btn-sm btn-outline-light rounded-pill ms-2 px-3">
                                                    <i class="fa-solid fa-expand me-1"></i>
                                                    Ver en grande
                                                </a>
                                            @endif

                                        </div>

                                    </div>

                                </div>

                            @endforeach

                        </div>

                        @if($recursos->count() > 1)

                            <button class="carousel-control-prev"
                                    type="button"
                                    data-bs-target="#carruselRecursosLeccion"
                                    data-bs-slide="prev">

                                <span class="carousel-control-prev-icon bg-dark rounded-circle p-3"
                                      aria-hidden="true"></span>

                                <span class="visually-hidden">Anterior</span>

                            </button>

                            <button class="carousel-control-next"
                                    type="button"
                                    data-bs-target="#carruselRecursosLeccion"
                                    data-bs-slide="next">

                                <span class="carousel-control-next-icon bg-dark rounded-circle p-3"
                                      aria-hidden="true"></span>

                                <span class="visually-hidden">Siguiente</span>

                            </button>

                        @endif

                    </div>

                @else

                    <div class="text-center bg-black p-4 rounded-4 border border-secondary shadow-lg">
                        <p class="text-muted mb-0 py-5">
                            No hay material visual adjunto para esta lección.
                        </p>
                    </div>

                @endif

            </div>

            <hr class="border-secondary my-4">

            <h5 class="text-success fw-semibold mb-3">Recursos Descargables</h5>

            @if($recursos->count())

                <div class="table-responsive rounded-3 overflow-hidden shadow-sm">

                    <table class="table table-dark table-hover table-bordered align-middle border-secondary mb-0">

                        <thead class="table-secondary text-dark">
                            <tr>
                                <th>Nombre del Archivo</th>
                                <th>Tipo</th>
                                <th width="180">Acción</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($recursos as $recurso)

                                @php
                                    $pathArchivo = $recurso->archivo ?? ($recurso->url ?? ($recurso->path ?? ''));
                                    $nombreItem = $recurso->nombre ?? ($recurso->titulo ?? 'Recurso');
                                    $extension = strtolower(pathinfo($pathArchivo, PATHINFO_EXTENSION));
                                    $urlDescarga = $obtenerUrlSegura($pathArchivo);
                                @endphp

                                <tr>

                                    <td>{{ $nombreItem }}</td>

                                    <td>{{ strtoupper($extension) }}</td>

                                    <td>
                                        @if($urlDescarga)

                                            <a href="{{ $urlDescarga }}"
                                               target="_blank"
                                               rel="noopener noreferrer"
                                               class="btn btn-success btn-sm rounded-pill px-3 fw-bold">

                                                <i class="fa-solid fa-download me-1"></i>
                                                Descargar / Ver

                                            </a>

                                        @else

                                            <span class="badge bg-danger">
                                                Archivo no encontrado
                                            </span>

                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @else

                <div class="alert alert-warning border-0 rounded-3">
                    Esta lección aún no tiene recursos descargables registrados.
                </div>

            @endif

            <hr class="border-secondary my-4">

            <form action="{{ route('leccion.completar', $leccion->id) }}" method="POST">
                @csrf

                <button class="btn btn-success fw-bold px-5 py-3 rounded-pill shadow-lg">
                    <i class="fa-solid fa-circle-check me-2"></i>
                    Marcar como completada
                </button>
            </form>

        </div>

    </div>

</div>
@endsection