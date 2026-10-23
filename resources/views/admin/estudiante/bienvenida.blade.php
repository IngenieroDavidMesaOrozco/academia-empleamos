@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="card shadow-lg border-0">

        <div class="card-body p-5 text-center">

            <h2 class="mb-3 fw-bold">Bienvenido a la Academia Corporativa</h2>

            <p class="text-muted mb-4">
                Antes de comenzar tus cursos, por favor mira el mensaje de bienvenida de nuestro gerente.
            </p>

            <div class="video-container mb-4">
                <video 
                    id="videoBienvenida"
                    src="{{ asset('videos/Bienvenida.mp4') }}"
                    controls
                    autoplay
                    muted
                    class="video-responsive"
                    playsinline
                >
                    Tu navegador no soporta la reproducción de videos.
                </video>
            </div>

            <div class="mb-3">
                <button onclick="toggleSound()" class="btn btn-outline-primary" id="soundBtn">
                    Activar sonido
                </button>
            </div>

            <form method="POST" action="{{ route('estudiante.bienvenida.completar') }}">
                @csrf

                <button class="btn btn-success btn-lg px-5">
                    He visto el mensaje y deseo continuar
                </button>
            </form>

        </div>

    </div>

</div>

<style>
.video-container {
    max-width: 100%;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #000;
    border-radius: 8px;
    overflow: hidden;
}

.video-responsive {
    max-width: 100%;
    max-height: 70vh;
    width: auto;
    height: auto;
    display: block;
    object-fit: contain;
}

/* Para pantallas pequeñas (vertical) */
@media (max-width: 768px) {
    .video-responsive {
        max-height: 50vh;
        width: 100%;
        height: auto;
    }
}

/* Para pantallas grandes (horizontal) */
@media (min-width: 769px) {
    .video-responsive {
        max-height: 70vh;
        width: auto;
        height: auto;
    }
}

/* Para cuando el usuario hace clic en pantalla completa */
.video-responsive:fullscreen {
    max-height: 100vh;
    max-width: 100vw;
    width: auto;
    height: auto;
    object-fit: contain;
}

.video-responsive::-webkit-media-controls-fullscreen-button {
    display: block;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const video = document.getElementById('videoBienvenida');
    const soundBtn = document.getElementById('soundBtn');

    // Intentar reproducir automáticamente (silenciado)
    video.play().catch(function(error) {
        console.log('Autoplay bloqueado:', error);
    });

    // Función para activar/desactivar sonido
    window.toggleSound = function() {
        if (video.muted) {
            video.muted = false;
            soundBtn.textContent = 'Silenciar';
            soundBtn.className = 'btn btn-outline-secondary';
            // Reproducir si está pausado
            if (video.paused) {
                video.play();
            }
        } else {
            video.muted = true;
            soundBtn.textContent = 'Activar sonido';
            soundBtn.className = 'btn btn-outline-primary';
        }
    };

    // Cuando el usuario hace clic en el video, activar sonido
    video.addEventListener('click', function() {
        if (video.muted) {
            video.muted = false;
            soundBtn.textContent = 'Silenciar';
            soundBtn.className = 'btn btn-outline-secondary';
        }
    });

    // Cuando el usuario sale de pantalla completa, mantener proporción
    document.addEventListener('fullscreenchange', function() {
        if (!document.fullscreenElement) {
            // Restaurar tamaño normal
        }
    });
});
</script>

@endsection