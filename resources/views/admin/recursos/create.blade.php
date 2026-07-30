@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3 class="mb-0">

                📂 Nuevo Recurso

            </h3>

        </div>

        <div class="card-body">

            <form action="{{ route('recursos.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label class="form-label">

                        Lección

                    </label>

                  <select
    name="leccion_id"
    class="form-select">

    @foreach($lecciones as $leccion)

        <option
            value="{{ $leccion->id }}"
            {{ (isset($leccionSeleccionada) && $leccionSeleccionada == $leccion->id) ? 'selected' : '' }}>

            {{ $leccion->titulo }}

        </option>

    @endforeach

</select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Nombre del recurso

                    </label>

                    <input
                         type="text"
    name="titulo"
    class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Tipo

                    </label>

                    <select
                        name="tipo"
                        class="form-select">

                        <option value="pdf">📄 PDF</option>

                        <option value="video">🎥 Video</option>

                        <option value="imagen">🖼 Imagen</option>

                        <option value="word">📝 Word</option>

                        <option value="excel">📊 Excel</option>

                        <option value="powerpoint">📽 PowerPoint</option>

                        <option value="zip">📦 ZIP</option>

                        <option value="otro">📁 Otro</option>

                    </select>

                </div>

                <div class="mb-4">

                    <label class="form-label">

                        Archivo

                    </label>

                    <input
                        type="file"
                        name="archivo"
                        class="form-control">

                </div>

                <button class="btn btn-success">

                    💾 Guardar Recurso

                </button>

                <a href="{{ route('recursos.index') }}"
                   class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</div>

@endsection