@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow">
                <div class="card-header">
                    <h4>Nueva Área</h4>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('areas.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nombre del área</label>
                            <input type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" placeholder="Ingrese el nombre del área" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" name="descripcion" rows="3" placeholder="Descripción del área">{{ old('descripcion') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">URL del Video (opcional)</label>
                            <input type="url" class="form-control" name="video" value="{{ old('video') }}" placeholder="https://www.youtube.com/embed/...">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Archivo de Diapositivas (PDF, PPT, PPTX)</label>
                            <input type="file" class="form-control" name="archivo_diapositivas" accept=".pdf,.ppt,.pptx">
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('areas.index') }}" class="btn btn-secondary me-2">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Área</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
