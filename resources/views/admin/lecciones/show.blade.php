@extends('layouts.app')

@php
    $tituloLeccion = $leccion->titulo ?? $leccion->nombre ?? 'Lección General';
    $descripcionLeccion =$leccion->descripcion ?? $leccion->contenido ?? $leccion->detalle ?? null;
    $moduloNombre = $leccion->modulo->nombre ?? $leccion->modulo->titulo ?? 'Módulo General';

    // Obtenemos todos los recursos asociados a la lección
    $recursos =$leccion->recursos ?? collect();
    $totalRecursos =$recursos->count();
@endphp

@section('page-title', $tituloLeccion)

@section('content')
<div class="container-fluid py-4 px-4" style="background: linear-gradient(135deg, #060913 0%, #110e25 100%); min-height: 90vh;">
    
    <!-- Cabecera de la Lección -->
    <div class="d-flex justify-content-between align-items-center mb-4 w-100">
        <div>
            <h3 class="fw-bold text-white mb-1"><i class="fa-solid fa-book-open-reader text-primary me-2"></i> {{ $tituloLeccion }}</h3>
            <p class="text-secondary mb-0 small">Módulo de Estudio: <span class="text-info fw-semibold">{{ $moduloNombre }}</span></p>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-outline-light btn-sm rounded-pill px-3 shadow-sm">
            <i class="fa-solid fa-arrow-left me-1"></i> Volver
        </a>
    </div>

    <!-- CONTENEDOR PRINCIPAL DEL LIBRO CON FLECHAS LATERALES -->
    <div class="d-flex align-items-center justify-content-center w-100 position-relative">
        
        <!-- Flecha Izquierda Flotante -->
        <button id="prevBtn" onclick="cambiarPagina(-1)" class="position-absolute start-0 translate-middle-y top-50 z-3 btn btn-dark text-white rounded-circle shadow-lg border border-secondary d-flex align-items-center justify-content-center floating-arrow" style="width: 50px; height: 50px; margin-left: -25px;">
            <i class="fa-solid fa-chevron-left fs-5"></i>
        </button>

        <!-- Tarjeta del Libro -->
        <div class="card border-0 shadow-lg rounded-4 overflow-hidden w-100" style="max-width: 1150px; background: #121722; border: 1px solid rgba(255,255,255,0.08) !important;">
            <div class="card-body p-4 p-md-5 position-relative" style="min-height: 580px;">
                
                @php $pageCounter = 1; @endphp

                <!-- PÁGINA 1: PORTADA -->
                <div class="book-page" data-page="{{ $pageCounter++ }}">
                    <div class="text-center py-5">
                        <div class="bg-primary bg-opacity-10 p-4 rounded-circle d-inline-block mb-3 text-primary shadow-sm">
                            <i class="fa-solid fa-graduation-cap fa-3x"></i>
                        </div>
                        <h2 class="fw-bold text-white mb-2 display-6">{{ $tituloLeccion }}</h2>
                        <p class="text-info fw-medium mb-3 fs-5">{{ $moduloNombre }}</p>
                        <hr class="w-25 mx-auto border-primary opacity-50 my-4">
                        <p class="text-white-50 mx-auto" style="max-width: 600px; font-size: 0.95rem;">
                            Este material contiene recursos multimedia interactivos (imágenes y videos). Haz clic en la flecha derecha o usa las teclas de tu teclado para recorrer el contenido.
                        </p>
                        <div class="text-secondary small mt-5 font-monospace">
                            <i class="fa-solid fa-keyboard me-1"></i> Tip: Usa las teclas <strong>←</strong> y <strong>→</strong> de tu teclado para navegar fluidamente.
                        </div>
                    </div>
                </div>

                <!-- PÁGINAS DINÁMICAS DE RECURSOS (Imágenes, Videos, PDFs) -->
                @foreach($recursos as $index =>$recurso)
                    @php
                        $archivo = $recurso->archivo ?? $recurso->url ?? null;
                        $extension = $archivo ? strtolower(pathinfo($archivo, PATHINFO_EXTENSION)) : '';
                        $esVideo = in_array($extension, ['mp4', 'webm', 'ogg', 'mov']);
                        $esImagen = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                        $esPdf = ($extension === 'pdf');

                        // LIMPIEZA DEL NOMBRE DEL RECURSO PARA QUE NO SALGA EL .JPG NI GUIONES FEOS
                        $nombreFuente = $recurso->nombre ?? ($archivo ? pathinfo($archivo, PATHINFO_FILENAME) : 'Recurso ' . ($index + 1));
                        $nombreLimpio = ucwords(str_replace(['_', '-'], ' ', pathinfo($nombreFuente, PATHINFO_FILENAME)));
                    @endphp

                    <div class="book-page d-none" data-page="{{ $pageCounter++ }}">
                        <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary border-opacity-25 pb-2">
                            <h6 class="text-primary fw-bold mb-0 text-truncate" style="max-width: 75%;">
                                <i class="fa-solid fa-photo-film me-2"></i> {{ $nombreLimpio }}
                            </h6>
                            <span class="badge bg-secondary bg-opacity-25 text-light px-3 py-1 rounded-pill">Recurso {{ $index + 1 }} de {{$totalRecursos }}</span>
                        </div>

                        <!-- Contenedor Multimedia Adaptativo (Sin fondo negro estricto) -->
                        <div class="position-relative mx-auto rounded-4 overflow-hidden shadow-inner d-flex align-items-center justify-content-center" style="height: 440px; width: 100%; background: transparent;">
                            @if($archivo)
                                @if($esImagen)
                                    <img src="{{ asset('storage/' . $archivo) }}" class="w-100 h-100" style="object-fit: contain; background: transparent;" alt="Recurso">
                                @elseif($esVideo)
                                    <video controls class="w-100 h-100 rounded-3 shadow" style="object-fit: contain; background: #000;">
                                        <source src="{{ asset('storage/' . $archivo) }}" type="video/{{ $extension }}">
                                        Tu navegador no soporta la reproducción de videos.
                                    </video>
                                @elseif($esPdf)
                                    <iframe src="{{ asset('storage/' . $archivo) }}#toolbar=0&navpanes=0&scrollbar=0" width="100%" height="100%" style="border: none; background: transparent;"></iframe>
                                @else
                                    <div class="text-center p-4 text-white-50">
                                        <i class="fa-solid fa-file-arrow-down fa-3x mb-3 text-primary"></i>
                                        <h6>Archivo adjunto disponible</h6>
                                        <a href="{{ asset('storage/' . $archivo) }}" target="_blank" class="btn btn-primary btn-sm mt-2 rounded-pill px-4">Descargar / Ver Archivo</a>
                                    </div>
                                @endif
                            @else
                                <div class="text-center text-muted">
                                    <i class="fa-solid fa-triangle-exclamation fa-2x mb-2 text-warning"></i>
                                    <p class="mb-0">El archivo no está disponible temporalmente.</p>
                                </div>
                            @endif
                        </div>

                        @if($archivo)
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="text-muted small"><i class="fa-solid fa-circle-info me-1"></i> Usa las flechas laterales para continuar examinando el material.</span>
                            <a href="{{ asset('storage/' . $archivo) }}" target="_blank" class="btn btn-outline-light btn-sm fw-bold px-3 rounded-pill">
                                <i class="fa-solid fa-expand me-1"></i> Pantalla Completa
                            </a>
                        </div>
                        @endif
                    </div>
                @endforeach

                <!-- PÁGINA DE NOTAS DEL INSTRUCTOR (Si existe descripción) -->
                @if($descripcionLeccion)
                <div class="book-page d-none" data-page="{{ $pageCounter++ }}">
                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom border-secondary border-opacity-25 pb-2">
                        <h6 class="text-info fw-bold mb-0">
                            <i class="fa-solid fa-note-sticky me-2"></i> Notas e Instrucciones del Instructor
                        </h6>
                        <span class="badge bg-secondary bg-opacity-25 text-light px-3 py-1 rounded-pill"></span>
                    </div>

                    <div class="p-4 rounded-4 bg-dark bg-opacity-50 border border-secondary border-opacity-25 overflow-auto shadow-inner" style="height: 440px;">
                        <div class="text-light fs-6 lh-lg" style="white-space: pre-line;">
                            {!! $descripcionLeccion !!}
                        </div>
                    </div>
                    <div class="text-secondary small text-center mt-3 font-monospace">
                        Has revisado las notas del instructor. Avanza a la última página para registrar tu asistencia.
                    </div>
                </div>
                @endif

                <!-- PÁGINA FINAL DE CIERRE -->
                <div class="book-page d-none" data-page="{{ $pageCounter }}">
                    <div class="text-center py-5">
                        <div class="bg-success bg-opacity-25 p-4 rounded-circle d-inline-block mb-3 text-success shadow-lg">
                            <i class="fa-solid fa-circle-check fa-3x text-success"></i>
                        </div>
                        <h3 class="fw-bold text-white mb-2">¡Has completado todos los recursos!</h3>
                        <p class="text-white-50 mx-auto mb-4 small" style="max-width: 500px;">
                            Has repasado todo el material audiovisual y las notas de esta lección. Haz clic en el botón inferior para registrar tu avance de forma oficial.
                        </p>

                        <form action="{{ route('leccion.completar', $leccion->id) }}" method="POST" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg px-5 py-3 rounded-pill shadow-lg fw-bold fs-6">
                                <i class="fa-solid fa-check-double me-2"></i> Finalizar Lección y Continuar <i class="fa-solid fa-arrow-right ms-2"></i>
                            </button>
                        </form>

                        <div class="text-muted small mt-4">
                            Puedes regresar usando la flecha izquierda si deseas repasar algún recurso anterior.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Flecha Derecha Flotante -->
        <button id="nextBtn" onclick="cambiarPagina(1)" class="position-absolute end-0 translate-middle-y top-50 z-3 btn btn-primary text-white rounded-circle shadow-lg d-flex align-items-center justify-content-center floating-arrow" style="width: 50px; height: 50px; margin-right: -25px;">
            <i class="fa-solid fa-chevron-right fs-5"></i>
        </button>

    </div>
</div>

<!-- ESTILOS Y ANIMACIONES -->
<style>
    .floating-arrow {
        transition: all 0.2s ease;
    }
    .floating-arrow:hover {
        transform: translateY(-50%) scale(1.1) !important;
    }
    .page-fade {
        animation: fadeIn 0.3s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.99); }
        to { opacity: 1; transform: scale(1); }
    }
</style>

<!-- SCRIPT DE CONTROL DINÁMICO DE PÁGINAS -->
<script>
    let paginaActual = 1;
    const totalPaginas = document.querySelectorAll('.book-page').length;

    function mostrarPagina(num) {
        const paginas = document.querySelectorAll('.book-page');
        paginas.forEach(page => {
            page.classList.add('d-none');
            page.classList.remove('page-fade');
        });

        const paginaActiva = document.querySelector(`.book-page[data-page="${num}"]`);
        if (paginaActiva) {
            paginaActiva.classList.remove('d-none');
            paginaActiva.classList.add('page-fade');
        }

        // Control de visibilidad de las flechas flotantes
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');
        
        prevBtn.style.opacity = num === 1 ? '0.3' : '1';
        prevBtn.style.pointerEvents = num === 1 ? 'none' : 'auto';

        nextBtn.style.opacity = num === totalPaginas ? '0.3' : '1';
        nextBtn.style.pointerEvents = num === totalPaginas ? 'none' : 'auto';
    }

    function cambiarPagina(direccion) {
        let nuevaPagina = paginaActual + direccion;
        if (nuevaPagina >= 1 && nuevaPagina <= totalPaginas) {
            paginaActual = nuevaPagina;
            mostrarPagina(paginaActual);
        }
    }

    // Navegación por teclado (Flechas izquierda y derecha)
    document.addEventListener('keydown', function(event) {
        if (event.key === 'ArrowRight') {
            cambiarPagina(1);
        } else if (event.key === 'ArrowLeft') {
            cambiarPagina(-1);
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        mostrarPagina(1);
    });
</script>
@endsection