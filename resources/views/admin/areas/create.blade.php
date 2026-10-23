@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                
                <!-- Encabezado corporativo limpio -->
                <div class="card-header text-white py-4 px-4" style="background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);">
                    <h3 class="mb-0 fs-4 fw-bold">Nueva Área</h3>
                    <p class="mb-0 text-white-50 small mt-1">Registra un nuevo departamento y asigna su identidad visual</p>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">

                    @if($errors->any())
                        <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4">
                            <ul class="mb-0 small fw-medium">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('areas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Nombre del Área -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small text-uppercase tracking-wider">Nombre del área</label>
                            <input
                                type="text"
                                name="nombre"
                                id="nombre_area"
                                class="form-control form-control-lg fs-6 shadow-none border-2"
                                value="{{ old('nombre') }}"
                                placeholder="Ej. Gestión Humana"
                                required
                                style="border-color: #e2e8f0; border-radius: 10px;">
                        </div>

                        <!-- SECCIÓN FOTOGRAFÍA CON PREVISUALIZACIÓN -->
                        <div class="mb-4">
                            <label class="form-label fw-bold text-dark small text-uppercase tracking-wider d-block mb-3">Fotografía del Líder</label>
                            
                            <div class="p-4 rounded-4 border border-2 border-light bg-light" style="background-color: #f8fafc !important;">
                                <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                                    
                                    <!-- Contenedor Visual del Avatar -->
                                    <div class="text-center">
                                        <div class="rounded-circle shadow-sm border border-3 border-white bg-primary text-white d-flex align-items-center justify-content-center fw-bold fs-3 mx-auto position-relative" style="width: 90px; height: 90px; overflow: hidden;">
                                            
                                            <!-- Iniciales dinámicas -->
                                            <span id="initials-text">ET</span>

                                            <!-- Imagen de Previsualización (Oculta hasta que elijan un archivo) -->
                                            <img id="avatar-img" src="" alt="Vista previa" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" style="display: none;">
                                        </div>

                                        <span id="badge-status" class="badge bg-secondary text-white rounded-pill mt-2 px-2 py-1" style="font-size: 9px; letter-spacing: 0.5px;">
                                            SIN FOTO
                                        </span>
                                    </div>

                                    <!-- Área de Carga -->
                                    <div class="flex-grow-1 w-100 text-center text-md-start">
                                        <label for="foto_lider_input" class="form-label small fw-semibold text-secondary mb-2">Cargar imagen de perfil:</label>
                                        
                                        <div class="input-group">
                                            <input
                                                type="file"
                                                name="foto_lider"
                                                id="foto_lider_input"
                                                class="form-control shadow-none border-2 py-2"
                                                accept="image/*"
                                                style="border-color: #cbd5e1; border-radius: 8px; font-size: 13px; background: #ffffff;">
                                        </div>
                                        <small class="text-muted d-block mt-2" style="font-size: 11px;">
                                            Formatos recomendados: JPG, PNG o WEBP. Tamaño máximo: 2MB.
                                        </small>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-end gap-3 pt-4 border-top">
                            <a href="{{ route('areas.index') }}" class="btn btn-light px-4 py-2 text-secondary fw-semibold rounded-pill border" style="border-color: #cbd5e1 !important;">
                                Cancelar
                            </a>

                            <button type="submit" class="btn btn-primary px-4 py-2 fw-semibold rounded-pill shadow-sm" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); border: none;">
                                Guardar Área
                            </button>
                        </div>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- Scripts interactivos -->
<script>
    // 1. Generar iniciales automáticas mientras escribe el nombre del área
    document.getElementById('nombre_area').addEventListener('input', function(event) {
        const val = event.target.value.trim();
        const initialsText = document.getElementById('initials-text');
        const avatarImg = document.getElementById('avatar-img');

        // Si no hay foto seleccionada, actualizamos las iniciales
        if (avatarImg.style.display !== 'block') {
            if (val.length >= 2) {
                initialsText.textContent = val.substring(0, 2).toUpperCase();
            } else if (val.length === 1) {
                initialsText.textContent = val.substring(0, 1).toUpperCase();
            } else {
                initialsText.textContent = 'ET';
            }
        }
    });

    // 2. Previsualizar la foto seleccionada al instante
    document.getElementById('foto_lider_input').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const avatarImg = document.getElementById('avatar-img');
                const initialsText = document.getElementById('initials-text');
                const badgeStatus = document.getElementById('badge-status');

                // Ocultamos las iniciales
                if (initialsText) {
                    initialsText.style.display = 'none';
                }

                // Mostramos la imagen cargada
                avatarImg.src = e.target.result;
                avatarImg.style.display = 'block';

                // Cambiamos el badge a verde
                badgeStatus.textContent = 'SELECCIONADA';
                badgeStatus.className = 'badge bg-success text-white rounded-pill mt-2 px-2 py-1';
            }
            reader.readAsDataURL(file);
        }
    });
</script>

<style>
    .form-control:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.15) !important;
    }
    .btn:hover {
        transform: translateY(-1px);
        opacity: 0.95;
    }
</style>
@endsection