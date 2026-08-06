@extends('layouts.app')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-header">
            <h3>Editar Área</h3>
        </div>

        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('areas.update', $area) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre del área</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $area->nombre) }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" rows="3">{{ old('descripcion', $area->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">URL del Video (opcional)</label>
                    <input type="url" class="form-control" name="video" value="{{ old('video', $area->video) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Archivo de Diapositivas (PDF, PPT, PPTX)</label>
                    <input type="file" class="form-control" name="archivo_diapositivas" accept=".pdf,.ppt,.pptx">
                    @if($area->archivo_diapositivas)
                        <small class="text-muted d-block mt-1">
                            Archivo actual: <a href="{{ asset('storage/' . $area->archivo_diapositivas) }}" target="_blank">Ver Archivo</a>
                        </small>
                    @endif
                </div>

                <a href="{{ route('areas.index') }}" class="btn btn-secondary">Cancelar</a>
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
</div>

@endsection
