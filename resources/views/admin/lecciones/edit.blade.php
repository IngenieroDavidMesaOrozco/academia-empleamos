@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Editar Leccion</h2>

    <form action="{{ route('lecciones.update', $leccion) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Modulo</label>
            <select name="modulo_id" class="form-control">
                @foreach($modulos as $modulo)
                    <option
                        value="{{ $modulo->id }}"
                        {{ $leccion->modulo_id == $modulo->id ? 'selected' : '' }}>
                        {{ $modulo->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Titulo</label>
            <input
                type="text"
                name="titulo"
                value="{{ $leccion->titulo }}"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Descripcion</label>
            <textarea
                name="descripcion"
                class="form-control">{{ $leccion->descripcion }}</textarea>
        </div>

        <div class="mb-3">
            <label>Video</label>
            <input
                type="text"
                name="video"
                value="{{ $leccion->video }}"
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Documento (URL externa)</label>
            <input
                type="text"
                name="documento"
                value="{{ $leccion->documento }}"
                class="form-control">
        </div>

        <!-- SECCION DE RECURSOS Y MINIATURAS ACTUALES -->
        <div class="mb-4 p-4 border rounded bg-white shadow-sm">
            <label class="font-weight-bold text-dark mb-3">Material de Apoyo Actual</label>
            
            @if($leccion->recursos->count() > 0)
                <div class="row g-3">
                    @foreach($leccion->recursos as $recurso)
                        @php
                            $extension = strtolower(pathinfo($recurso->archivo, PATHINFO_EXTENSION));
                            $esImagen = in_array($extension, ['jpg', 'jpeg', 'png', 'webp']);
                        @endphp
                        <div class="col-md-3 text-center border p-2 rounded bg-light">
                            @if($esImagen)
                                <img src="{{ asset('storage/' . $recurso->archivo) }}" class="img-fluid rounded mb-2 shadow-sm" style="height: 100px; object-fit: contain;" alt="Recurso">
                            @else
                                <div class="py-4 text-danger bg-white rounded mb-2 border">
                                    <span class="font-weight-bold uppercase">{{ $extension }}</span>
                                </div>
                            @endif
                            <a href="{{ asset('imagenes/' . $recurso->archivo) }}" target="_blank" class="d-block text-truncate text-primary font-weight-semibold small" title="{{ $recurso->titulo }}">
                                {{ $recurso->titulo }}
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-muted small mb-2">No hay archivos adjuntos en esta leccion.</p>
            @endif

            <label class="font-weight-bold text-dark mt-3">Agregar Nuevos Archivos</label>
            <input
                type="file"
                name="recursos[]"
                class="form-control-file mt-1"
                multiple>
            <small class="form-text text-muted">Puedes seleccionar varios archivos adicionales.</small>
        </div>

        <div class="mb-3">
            <label>Orden</label>
            <input
                type="number"
                name="orden"
                value="{{ $leccion->orden }}"
                class="form-control">
        </div>

        <button class="btn btn-primary">
            Actualizar
        </button>

        <a href="{{ route('lecciones.index') }}"
           class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

@endsection