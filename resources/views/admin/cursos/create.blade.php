@extends('layouts.app')

@section('page-title', 'Editar Capacitación')

@section('content')
<div class="container-fluid py-4" style="max-width: 1400px;">

    <!-- ENCABEZADO DE ELITE LIMPIO -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
        <div>
            <div class="d-inline-flex align-items-center bg-primary bg-opacity-10 text-primary px-3 py-1 rounded-pill fw-bold small mb-2 shadow-sm">
                <i class="fa-solid fa-pen-to-square me-2"></i> Panel de Administracion
            </div>
            <h2 class="fw-bold text-dark mb-1" style="font-size: 1.75rem;">Editar Capacitacion</h2>
            <p class="text-muted small mb-0">Actualiza la informacion general, la galeria del carrusel y los documentos asociados.</p>
        </div>
        <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary px-4 py-2 rounded-pill fw-semibold shadow-sm bg-white border-0">
            <i class="fa-solid fa-arrow-left me-1 text-primary"></i> Volver al listado
        </a>
    </div>

    <!-- Mensajes de error -->
    @if ($errors->any())
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4" style="background-color: #fdf2f2; color: #b91c1c;">
            <div class="fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-2"></i> Corrige los siguientes errores:</div>
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

                <!-- BLOQUE 1: INFORMACION GENERAL -->
                <div class="card shadow-sm border-0 p-4 p-md-5 mb-4 rounded-4 bg-white">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; min-width: 45px;">
                            <i class="fa-solid fa-book-bookmark fs-5"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0 fs-5">1. Informacion General y Area Asociada</h5>
                            <small class="text-muted">Modifica el titulo, el estado, la descripcion y revisa el area vinculada.</small>
                        </div>
                    </div>
                    
                    <div class="row g-4 align-items-center">
                        <div class="col-md-7">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Area Asociada *</label>
                                    <select name="area_id" class="form-select bg-light border-0 py-2.5 rounded-3 text-dark shadow-none" required>
                                        @foreach($areas as $area)
                                            <option value="{{ $area->id }}" {{ $curso->area_id == $area->id ? 'selected' : '' }}>
                                                {{ $area->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-secondary small">Estado del Curso *</label>
                                    <select name="estado" class="form-select bg-light border-0 py-2.5 rounded-3 text-dark shadow-none" required>
                                        <option value="1" {{ $curso->estado ? 'selected' : '' }}>Activo (Visible)</option>
                                        <option value="0" {{ !$curso->estado ? 'selected' : '' }}>Inactivo (Oculto)</option>
                                    </select>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold text-secondary small">Nombre del Curso *</label>
                                    <input type="text" name="nombre" value="{{ old('nombre', $curso->nombre) }}" class="form-control bg-light border-0 py-2.5 rounded-3 text-dark shadow-none" required>
                                </div>
                            </div>
                        </div>

                        <!-- VISTA PREVIA CLARA DE LA FOTO DEL LIDER VINCULADA AL AREA -->
                        <div class="col-md-5">
                            <div class="p-3 bg-light border rounded-4 text-center">
                                <span class="d-block small fw-bold text-dark mb-2">Foto del Lider (Tarjeta del Estudiante)</span>
                                <div class="d-flex justify-content-center mb-2">
                                    @if(!empty($curso->area) && !empty($curso->area->foto_lider))
                                        @php
                                            $fotoLiderRuta = Str::startsWith($curso->area->foto_lider, 'storage/') 
                                                ? asset($curso->area->foto_lider) 
                                                : asset('storage/' . str_replace('public/', '', $curso->area->foto_lider));
                                        @endphp
                                        <img src="{{ $fotoLiderRuta }}" alt="Foto Lider" class="rounded-circle shadow-sm border" style="width: 80px; height: 80px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center shadow-sm" style="width: 80px; height: 80px;">
                                            <i class="fa-solid fa-user-tie fs-4"></i>
                                        </div>
                                    @endif
                                </div>
                                <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">Esta foto se hereda del area seleccionada.</small>
                                <a href="{{ route('areas.index') }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-pen me-1"></i> Cambiar foto en el modulo Areas
                                </a>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold text-secondary small">Descripcion Detallada</label>
                            <textarea name="descripcion" rows="3" class="form-control bg-light border-0 rounded-3 text-dark shadow-none" required>{{ old('descripcion', $curso->descripcion) }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- BLOQUE 2: GALERIA / CARRUSEL INTERNO DEL CURSO -->
                <div class="card shadow-sm border-0 p-4 p-md-5 mb-4 rounded-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom flex-wrap gap-3">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; min-width: 45px;">
                                <i class="fa-solid fa-images fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0 fs-5">2. Galeria / Carrusel Interno de este Curso</h5>
                                <small class="text-muted">Imagenes secundarias que se muestran al interior del contenido del curso.</small>
                            </div>
                        </div>
                        <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill fw-semibold">
                            {{ count($curso->fotos_equipo ?? []) }} Imagenes en Carrusel
                        </span>
                    </div>

                    @if(!empty($curso->fotos_equipo) && count($curso->fotos_equipo) > 0)
                        <div class="row g-3 mb-4">
                            @foreach($curso->fotos_equipo as $index => $foto)
                                <div class="col-md-4 col-sm-6">
                                    <div class="card border shadow-sm rounded-4 overflow-hidden h-100 bg-light">
                                        <div class="ratio ratio-16x9 bg-white">
                                            <img src="{{ asset($foto) }}" alt="Foto carrusel {{ $index + 1 }}" class="w-100 h-100 object-fit-cover">
                                        </div>
                                        <div class="card-footer bg-white border-top py-3 px-3 d-flex justify-content-between align-items-center">
                                            <small class="text-muted fw-semibold">Carrusel #{{ $index + 1 }}</small>
                                            <div class="form-check m-0">
                                                <input class="form-check-input border-danger" type="checkbox" name="eliminar_fotos[]" value="{{ $foto }}" id="del_foto_{{ $index }}">
                                                <label class="form-check-label text-danger small fw-bold" for="del_foto_{{ $index }}">
                                                    Eliminar
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4 border border-dashed rounded-4 bg-light mb-4">
                            <i class="fa-solid fa-image text-muted fs-3 mb-2"></i>
                            <p class="text-muted small mb-0">No hay imagenes en el carrusel interno de este curso actualmente.</p>
                        </div>
                    @endif

                    <div class="p-3 border rounded-3 bg-light">
                        <label class="form-label small text-dark fw-semibold mb-2">
                            <i class="fa-solid fa-cloud-arrow-up me-1 text-primary"></i> Anadir Nuevas Imagenes al Carrusel (Seleccion multiple):
                        </label>
                        <input type="file" name="fotos_equipo[]" multiple accept="image/*" class="form-control bg-white border-0 py-2 rounded-3 text-dark shadow-none" id="inputFotosMasivas">
                        
                        <div id="fileHelpBlock" class="form-text text-success small mt-2 fw-semibold d-none">
                            <i class="fa-solid fa-circle-check me-1"></i> <span id="contadorArchivos">0</span> imagenes seleccionadas listas para subir.
                        </div>
                    </div>
                </div>

                <!-- BLOQUE 3: DOCUMENTO PDF DEL CURSO -->
                <div class="card shadow-sm border-0 p-4 p-md-5 mb-4 rounded-4 bg-white">
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="bg-warning bg-opacity-20 text-dark rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; min-width: 45px;">
                            <i class="fa-solid fa-file-pdf fs-5 text-warning"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold text-dark mb-0 fs-5">3. Documento o Presentacion PDF del Curso</h5>
                            <small class="text-muted">Sube o reemplaza el archivo de estudio principal.</small>
                        </div>
                    </div>

                    <div class="p-3 border rounded-3 bg-light">
                        <label class="form-label small text-dark fw-semibold mb-2">
                            <i class="fa-solid fa-file-arrow-up me-1 text-warning"></i> Seleccionar archivo PDF nuevo:
                        </label>
                        <input type="file" name="archivo_pdf" accept=".pdf" class="form-control bg-white border-0 py-2 rounded-3 text-dark shadow-none">
                        <small class="text-muted d-block mt-2" style="font-size: 0.8rem;">
                            Si ya cuenta con un documento y subes uno nuevo, se actualizara automaticamente.
                        </small>
                    </div>
                </div>

                <!-- BOTONES DE ACCION -->
                <div class="d-flex justify-content-end gap-3 my-4">
                    <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary px-4 py-2.5 rounded-pill fw-semibold">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary px-5 py-2.5 fw-bold shadow-sm rounded-pill">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Actualizar Curso
                    </button>
                </div>

            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('inputFotosMasivas').addEventListener('change', function(e) {
        var count = e.target.files.length;
        var helpBlock = document.getElementById('fileHelpBlock');
        var counterSpan = document.getElementById('contadorArchivos');
        if (count > 0) {
            counterSpan.textContent = count;
            helpBlock.classList.remove('d-none');
        } else {
            helpBlock.classList.add('d-none');
        }
    });
</script>
@endsection