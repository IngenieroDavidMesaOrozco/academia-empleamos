@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Configuración del Sistema</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('parametros.update') }}" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="tiempo_para_cambio_contraseña" class="form-label">
                Días permitidos entre cada cambio obligatorio de contraseña
            </label>
            <input type="number" name="tiempo_para_cambio_contraseña" class="form-control" min="1" max="365"
                   value="{{ old('tiempo_para_cambio_contraseña', $parametro->tiempo_para_cambio_contraseña) }}" required>
        </div>

        <div class="mb-4">
            <h4>Video de Bienvenida</h4>
            
            <!-- Verificar si existe el video -->
            @if(file_exists(public_path('videos/Bienvenida.mp4')))
                <div class="mb-3">
                    <label class="form-label">Video actual:</label>
                    <div class="video-container">
                        <video 
                            controls
                            class="video-responsive"
                            style="background: #000; border-radius: 8px;"
                        >
                            <source src="{{ asset('videos/Bienvenida.mp4') }}" type="video/mp4">
                            Tu navegador no soporta la reproducción de videos.
                        </video>
                    </div>
                </div>
                
                <button type="submit" name="eliminar_video" value="1" class="btn btn-danger btn-sm mb-3"
                        onclick="return confirm('¿Eliminar video?')">
                    <i class="fas fa-trash"></i> Eliminar video
                </button>
            @else
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle"></i> No hay video de bienvenida
                </div>
            @endif

            <div class="mb-3">
                <label for="video_bienvenida" class="form-label">Subir video (MP4):</label>
                <input type="file" 
                       name="video_bienvenida" 
                       id="video_bienvenida" 
                       class="form-control"
                       accept=".mp4,video/mp4">
                <small class="text-muted">Máximo 50MB. Solo MP4.</small>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
    <br>
    <a class="btn btn-primary mb-3" href="{{ route('home') }}"><- Volver Home</a>
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
</style>

<script>
document.getElementById('video_bienvenida')?.addEventListener('change', function() {
    if (this.files && this.files[0]) {
        const file = this.files[0];
        if (!file.name.toLowerCase().endsWith('.mp4')) {
            alert('Solo MP4');
            this.value = '';
        }
        if (file.size > 50 * 1024 * 1024) {
            alert('Máximo 50MB');
            this.value = '';
        }
    }
});
</script>
@endsection