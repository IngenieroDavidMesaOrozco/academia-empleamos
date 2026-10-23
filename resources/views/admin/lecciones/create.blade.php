@extends('layouts.app')

@section('page-title', 'Nueva Lección')

@section('content')

<style>
    /* =========================================================
        ESTILOS FORMULARIO NUEVA LECCIÓN
    ========================================================= */
    :root {
        --primary: #2563eb;
        --primary-light: #eff6ff;
        --success: #16a34a;
        --bg: #f5f7fb;
        --card: #ffffff;
        --border: #e5e7eb;
        --text: #111827;
        --muted: #6b7280;
        --radius: 18px;
    }

    .form-wrapper {
        background: var(--bg);
        min-height: calc(100vh - 80px);
        padding: 20px 0 45px;
    }

    .form-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: var(--radius);
        box-shadow: 0 4px 18px rgba(15,23,42,.04);
        padding: 30px;
    }

    .form-label-custom {
        font-size: .8rem;
        font-weight: 800;
        color: var(--text);
        text-transform: uppercase;
        letter-spacing: .4px;
        margin-bottom: 6px;
        display: block;
    }

    .form-control, .form-select {
        border-radius: 12px;
        border: 1px solid var(--border);
        padding: 11px 15px;
        font-size: .88rem;
        color: var(--text);
        background-color: #fafbfc;
        transition: all .2s ease;
    }

    .form-control:focus, .form-select:focus {
        background-color: #fff;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(37,99,235,.1);
    }

    .upload-box {
        border: 2px dashed #cbd5e1;
        background: #f8fafc;
        border-radius: 14px;
        padding: 20px;
        text-align: center;
        transition: all .2s ease;
    }

    .upload-box:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .btn-action {
        border-radius: 12px;
        font-size: .85rem;
        font-weight: 700;
        padding: 10px 20px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Modo oscuro compatible */
    [data-bs-theme="dark"] .form-wrapper { background: #111827; }
    [data-bs-theme="dark"] .form-card { background: #1f2937; border-color: #374151; }
    [data-bs-theme="dark"] .form-label-custom { color: #f9fafb; }
    [data-bs-theme="dark"] .form-control, [data-bs-theme="dark"] .form-select { background: #111827; border-color: #374151; color: #f9fafb; }
    [data-bs-theme="dark"] .upload-box { background: #18212f; border-color: #475569; }
</style>

<div class="form-wrapper">
    <div class="container" style="max-width: 800px;">
        
        <!-- Encabezado -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-1" style="font-size: 0.75rem;">
                        <li class="breadcrumb-item"><a href="{{ route('lecciones.index') }}" class="text-decoration-none">Lecciones</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Nueva</li>
                    </ol>
                </nav>
                <h2 class="fw-bold mb-0" style="color: var(--text); font-size: 1.6rem;">Crear Nueva Lección</h2>
            </div>
            <a href="{{ route('lecciones.index') }}" class="btn btn-outline-secondary btn-action">
                <i class="fa-solid fa-arrow-left"></i> Volver
            </a>
        </div>

        <!-- Tarjeta del Formulario -->
        <div class="form-card">
            
            <form action="{{ route('lecciones.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Módulo -->
                <div class="mb-3">
                    <label class="form-label-custom">Módulo del Curso</label>
                    <select name="modulo_id" class="form-select @error('modulo_id') is-invalid @enderror" required>
                        <option value="">Seleccione un módulo...</option>
                        @foreach($modulos as $modulo)
                            <option value="{{ $modulo->id }}" {{ old('modulo_id') == $modulo->id ? 'selected' : '' }}>
                                {{ $modulo->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('modulo_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Título -->
                <div class="mb-3">
                    <label class="form-label-custom">Título de la Lección</label>
                    <input 
                        type="text" 
                        name="titulo" 
                        class="form-control @error('titulo') is-invalid @enderror" 
                        value="{{ old('titulo') }}" 
                        placeholder="Ej. Introducción a la plataforma"
                        required>
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label class="form-label-custom">Descripción</label>
                    <textarea 
                        name="descripcion" 
                        class="form-control @error('descripcion') is-invalid @enderror" 
                        rows="4" 
                        placeholder="Breve resumen o contenido de la lección...">{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <!-- Video URL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Video (URL de YouTube)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;">
                                <i class="fa-brands fa-youtube text-danger"></i>
                            </span>
                            <input 
                                type="url" 
                                name="video" 
                                class="form-control border-start-0 @error('video') is-invalid @enderror" 
                                value="{{ old('video') }}" 
                                placeholder="https://youtube.com/watch?v=...">
                        </div>
                        @error('video')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Documento URL -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label-custom">Documento Externo (Opcional)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;">
                                <i class="fa-solid fa-link text-primary"></i>
                            </span>
                            <input 
                                type="url" 
                                name="documento" 
                                class="form-control border-start-0 @error('documento') is-invalid @enderror" 
                                value="{{ old('documento') }}" 
                                placeholder="https://drive.google.com/...">
                        </div>
                        @error('documento')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Material de Apoyo (Múltiple) -->
                <div class="mb-4">
                    <label class="form-label-custom">Material de Apoyo (Archivos Locales)</label>
                    <div class="upload-box">
                        <i class="fa-solid fa-cloud-arrow-up fa-2x text-primary mb-2"></i>
                        <p class="mb-1 fw-semibold text-muted small">Arrastra tus archivos aquí o haz clic para buscar</p>
                        <input 
                            type="file" 
                            name="recursos[]" 
                            class="form-control mt-2" 
                            multiple>
                        <small class="form-text text-muted d-block mt-1">Formatos permitidos: PDF, PowerPoint, Word, JPG, PNG.</small>
                    </div>
                    @error('recursos.*')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Orden -->
                <div class="mb-4" style="max-width: 200px;">
                    <label class="form-label-custom">Número de Orden</label>
                    <input 
                        type="number" 
                        name="orden" 
                        value="{{ old('orden', 1) }}" 
                        class="form-control" 
                        min="1">
                </div>

                <!-- Botones de Acción -->
                <div class="d-flex gap-2 justify-content-end border-top pt-3">
                    <a href="{{ route('lecciones.index') }}" class="btn btn-light btn-action border">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success btn-action">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Lección
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>

@endsection