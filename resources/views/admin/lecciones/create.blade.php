@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Nueva Lección</h2>

    <form action="{{ route('lecciones.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Módulo</label>

            <select name="modulo_id" class="form-control" required>

                <option value="">Seleccione...</option>

                @foreach($modulos as $modulo)

                    <option value="{{ $modulo->id }}">
                        {{ $modulo->nombre }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Título</label>

            <input
                type="text"
                name="titulo"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label>Descripción</label>

            <textarea
                name="descripcion"
                class="form-control"
                rows="4"></textarea>

        </div>

        <div class="mb-3">

            <label>Video (URL)</label>

            <input
                type="text"
                name="video"
                class="form-control"
                placeholder="https://youtube.com/...">

        </div>

        <div class="mb-3">

            <label>Documento (URL)</label>

            <input
                type="text"
                name="documento"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Orden</label>

            <input
                type="number"
                name="orden"
                value="1"
                class="form-control">

        </div>

        <button class="btn btn-success">

            Guardar Lección

        </button>

        <a href="{{ route('lecciones.index') }}"
           class="btn btn-secondary">

            Cancelar

        </a>

    </form>

</div>

@endsection 