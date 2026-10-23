@extends('layouts.app')

@section('page-title', 'Editar Capacitación')

@section('content')
<div class="container-fluid py-4" style="max-width: 1400px;">

    <!-- ENCABEZADO -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <div class="d-inline-flex align-items-center bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold small mb-2 shadow-sm">
                <i class="fa-solid fa-pen-to-square me-2"></i> Panel de Administración
            </div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">Editar Capacitación: {{ $curso->nombre }}</h2>
            <p class="text-muted small mb-0">
                Actualiza la información general, el contenido por módulos y los recursos asociados.
            </p>
        </div>

        <a href="{{ route('cursos.index') }}"
           class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold shadow-sm bg-white border-0">
            <i class="fa-solid fa-arrow-left me-1 text-primary"></i> Volver al listado
        </a>
    </div>

    <!-- MENSAJES DE ERROR -->
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4" style="background-color: #fdf2f2; color: #b91c1c;">
            <div class="fw-bold mb-1">
                <i class="fa-solid fa-triangle-exclamation me-2"></i> Corrige los siguientes errores:
            </div>
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('cursos.update', $curso) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-12">

                <!-- BLOQUE 1: INFORMACIÓN GENERAL -->
                <div class="card shadow-sm border-0 p-4 p-md-5 mb-4 rounded-4 bg-white">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; min-width: 45px;">
                            <i class="fa-solid fa-book-bookmark fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0 fs-5">1. Información General y Área Asociada</h5>
                            <small class="text-muted">Modifica el título, el estado, la descripción y revisa el área vinculada.</small>
                        </div>
                    </div>

                    <div class="row g-4 align-items-center">
                        <div class="col-md-7">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Área Asociada *</label>
                                    <select name="area_id" class="form-select bg-light border-0 py-2 rounded-3 text-dark shadow-none" required>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" {{ old('area_id', $curso->area_id) == $area->id ? 'selected' : '' }}>
                                                {{ $area->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Estado del Curso *</label>
                                    <select name="estado" class="form-select bg-light border-0 py-2 rounded-3 text-dark shadow-none" required>
                                        <option value="1" {{ (string) old('estado', $curso->estado) === '1' ? 'selected' : '' }}>Activo (Visible)</option>
                                        <option value="0" {{ (string) old('estado', $curso->estado) === '0' ? 'selected' : '' }}>Inactivo (Oculto)</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold text-secondary small">Nombre del Curso *</label>
                                    <input type="text" name="nombre" value="{{ old('nombre', $curso->nombre) }}" class="form-control bg-light border-0 py-2 rounded-3 text-dark shadow-none" required>
                                </div>
                            </div>
                        </div>

                        <!-- FOTO DEL LÍDER DEL ÁREA -->
                        <div class="col-md-5">
                            <div class="p-3 bg-light border rounded-4 text-center">
                                <span class="d-block small fw-bold text-dark mb-2">Foto del Líder (Tarjeta del Estudiante)</span>
                                <div class="d-flex justify-content-center mb-2">
                                    @if(!empty($curso->area) && $curso->area->foto_lider_url)
                                        <img src="{{ $curso->area->foto_lider_url }}" alt="Foto del líder" class="rounded-circle shadow-sm border" style="width: 80px; height: 80px; object-fit: cover;" onerror="this.style.display='none';">
                                    @else
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px;">
                                            <i class="fa-solid fa-user-tie fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                                <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">Esta foto se hereda del área seleccionada.</small>
                                <a href="{{ route('areas.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-pen me-1"></i> Cambiar foto en el módulo Áreas
                                </a>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary small">Descripción Detallada</label>
                            <textarea name="descripcion" rows="3" class="form-control bg-light border-0 rounded-3 text-dark shadow-none" required>{{ old('descripcion', $curso->descripcion) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- BLOQUE 2: GESTIÓN DE CONTENIDO POR MÓDULOS (5 a 7 Módulos) -->
                <div class="card shadow-sm border-0 p-4 p-md-5 mb-4 rounded-4 bg-white">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; min-width: 45px;">
                            <i class="fa-solid fa-layer-group fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0 fs-5">2. Contenido Organizado por Módulos y Lecciones</h5>
                            <small class="text-muted">Administra los títulos y recursos específicos para cada módulo de este curso.</small>
                        </div>
                    </div>

                    <div class="accordion" id="accordionModulosEdit">
                        @foreach($curso->modulos as $index => $modulo)
                            <div class="accordion-item border shadow-sm mb-3 rounded-4 overflow-hidden bg-white">
                                <h2 class="accordion-header" id="headingMod{{ $modulo->id }}">
                                    <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }} fw-bold bg-light text-dark py-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMod{{ $modulo->id }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                                        <i class="fa-solid fa-folder-open me-2 text-primary"></i> Módulo {{ $index + 1 }}: {{ $modulo->nombre }}
                                    </button>
                                </h2>
                                <div id="collapseMod{{ $modulo->id }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#accordionModulosEdit">
                                    <div class="accordion-body p-4 bg-white">
                                        
                                        <input type="hidden" name="modulos[{{ $index }}][id]" value="{{ $modulo->id }}">

                                        <div class="row g-3 mb-3">
                                            <div class="col-md-6">
                                                <label class="form-label small fw-semibold text-secondary">Nombre del Módulo</label>
                                                <input type="text" name="modulos[{{ $index }}][nombre]" value="{{ old('modulos.'.$index.'.nombre', $modulo->nombre) }}" class="form-control bg-light border-0 py-2 rounded-3" required>
                                            </div>
                                            <div class="col-md-6">
                                                @php $leccion = $modulo->lecciones->first(); @endphp
                                                @if($leccion)
                                                    <input type="hidden" name="modulos[{{ $index }}][leccion_id]" value="{{ $leccion->id }}">
                                                    <label class="form-label small fw-semibold text-secondary">Título de la Lección / Clase</label>
                                                    <input type="text" name="modulos[{{ $index }}][leccion_titulo]" value="{{ old('modulos.'.$index.'.leccion_titulo', $leccion->titulo) }}" class="form-control bg-light border-0 py-2 rounded-3" required>
                                                @endif
                                            </div>
                                        </div>

                                        <!-- RECURSOS Y MINIATURAS ACTUALES -->
                                        <div class="mb-4">
                                            <label class="form-label small fw-bold text-dark mb-2">
                                                <i class="fa-solid fa-images me-1 text-info"></i> Archivos e Imágenes actuales en este Módulo:
                                            </label>

                                            <div class="row g-3">
                                                @php 
                                                    $recursosLeccion = $leccion ? $leccion->recursos : collect();
                                                @endphp

                                                @forelse($recursosLeccion as $recurso)
                                                    @php
                                                        $extension = strtolower(pathinfo($recurso->archivo, PATHINFO_EXTENSION));
                                                        $esImagen = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                                                        $urlRecurso = \App\Models\Curso::resolverImagen($recurso->archivo);
                                                    @endphp

                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="card border shadow-none rounded-3 p-2 bg-light h-100 position-relative">
                                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                                @if($esImagen && $urlRecurso)
                                                                    <div class="rounded-2 overflow-hidden bg-white border" style="width: 50px; height: 50px; min-width: 50px;">
                                                                        <img src="{{ $urlRecurso }}" alt="{{ $recurso->nombre }}" class="w-100 h-100 object-fit-cover">
                                                                    </div>
                                                                @else
                                                                    <div class="rounded-2 bg-warning bg-opacity-20 text-warning d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; min-width: 50px;">
                                                                        <i class="fa-solid fa-file-pdf fs-5"></i>
                                                                    </div>
                                                                @endif

                                                                <div class="overflow-hidden">
                                                                    <span class="d-block small fw-bold text-dark text-truncate" title="{{ $recurso->nombre }}">
                                                                        {{ $recurso->nombre }}
                                                                    </span>
                                                                    <span class="badge bg-secondary bg-opacity-10 text-secondary" style="font-size: 10px;">
                                                                        {{ strtoupper($extension) }}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                            <div class="form-check border-top pt-2 mt-auto">
                                                                <input class="form-check-input border-danger" type="checkbox" name="eliminar_recursos[]" value="{{ $recurso->id }}" id="del_rec_{{ $recurso->id }}">
                                                                <label class="form-check-label text-danger small fw-bold" for="del_rec_{{ $recurso->id }}">
                                                                    <i class="fa-solid fa-trash-can me-1"></i> Eliminar este archivo
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="col-12">
                                                        <p class="text-muted small fst-italic mb-0 bg-light p-3 rounded-3 border text-center">
                                                            No hay archivos o imágenes cargados en este módulo todavía.
                                                        </p>
                                                    </div>
                                                @endforelse
                                            </div>
                                        </div>

                                        <!-- BOTÓN DE CARGA MODERNO PARA NUEVOS ARCHIVOS -->
                                        <div class="p-3 border border-dashed rounded-3 bg-light">
                                            <label class="form-label small fw-semibold text-primary mb-2">
                                                <i class="fa-solid fa-cloud-arrow-up me-1"></i> Agregar nuevas imágenes o documentos al Módulo {{ $index + 1 }}:
                                            </label>
                                            <input type="file" name="modulos[{{ $index }}][recursos][]" multiple accept=".pdf,.ppt,.pptx,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.webp" class="form-control bg-white border-0 py-2 rounded-3 text-dark shadow-none input-archivos-modulo">
                                            <small class="text-muted d-block mt-2" style="font-size: 11px;">
                                                Puedes seleccionar múltiples archivos o imágenes. Se mostrarán automáticamente en la vista del estudiante.
                                            </small>

                                            <!-- Contenedor dinámico para la previsualización en vivo -->
                                            <div class="preview-nuevos-archivos row g-2 mt-3"></div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- BOTONES DE ACCIÓN -->
                <div class="d-flex justify-content-end gap-3 my-4 flex-wrap">
                    <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-5 py-2 fw-bold shadow-sm rounded-pill">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar Curso y Módulos
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const inputsArchivos = document.querySelectorAll('.input-archivos-modulo');

    inputsArchivos.forEach(input => {
        input.addEventListener('change', function (event) {
            const files = event.target.files;
            const previewContainer = input.parentElement.querySelector('.preview-nuevos-archivos');
            previewContainer.innerHTML = '';

            if (files.length > 0) {
                const tituloPreview = document.createElement('div');
                tituloPreview.className = 'col-12 small fw-bold text-success mb-1';
                tituloPreview.innerHTML = `<i class="fa-solid fa-eye me-1"></i> Previsualización de archivos listos para subir (${files.length}):`;
                previewContainer.appendChild(tituloPreview);

                Array.from(files).forEach((file) => {
                    const reader = new FileReader();
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-sm-4';

                    if (file.type.startsWith('image/')) {
                        reader.onload = function (e) {
                            col.innerHTML = `
                                <div class="card border border-success shadow-none rounded-3 p-2 bg-white h-100">
                                    <div class="mb-2 rounded-2 overflow-hidden border bg-light d-flex align-items-center justify-content-center" style="height: 90px;">
                                        <img src="${e.target.result}" class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <span class="d-block small text-dark fw-bold text-truncate" title="${file.name}">${file.name}</span>
                                    <span class="badge bg-success bg-opacity-10 text-success mt-1" style="font-size: 9px;">Listo para guardar</span>
                                </div>
                            `;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        col.innerHTML = `
                            <div class="card border border-success shadow-none rounded-3 p-2 bg-white h-100">
                                <div class="mb-2 rounded-2 bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center border" style="height: 90px;">
                                    <i class="fa-solid fa-file-pdf fs-2"></i>
                                </div>
                                <span class="d-block small text-dark fw-bold text-truncate" title="${file.name}">${file.name}</span>
                                <span class="badge bg-success bg-opacity-10 text-success mt-1" style="font-size: 9px;">Documento listo</span>
                            </div>
                        `;
                    }

                    previewContainer.appendChild(col);
                });
            }
        });
    });
});
</script>
@endsection