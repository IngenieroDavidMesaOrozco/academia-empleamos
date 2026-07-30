@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Nuevo Curso</h2>

    <form action="{{ route('cursos.store') }}" method="POST">

        @csrf

        <div class="mb-3">
            <label>Área</label>

            <select name="area_id" class="form-control" required>

                <option value="">Seleccione...</option>

                @foreach($areas as $area)

                    <option value="{{ $area->id }}">

                        {{ $area->nombre }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Nombre del curso</label>

            <input
                type="text"
                name="nombre"
                class="form-control"
                required>

        </div>

        <div class="mb-3">

            <label>Descripción</label>

            <textarea
                name="descripcion"
                class="form-control"></textarea>

        </div>

        <div class="mb-3">

            <label>Imagen</label>

            <input
                type="text"
                name="imagen"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Estado</label>

            <select name="estado" class="form-control">

                <option value="1">Activo</option>

                <option value="0">Inactivo</option>

            </select>

        </div>

        <button class="btn btn-success">
            Guardar
        </button>

        <a href="{{ route('cursos.index') }}" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

@endsection