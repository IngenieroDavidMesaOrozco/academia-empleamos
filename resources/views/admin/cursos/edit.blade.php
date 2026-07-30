@extends('layouts.app')

@section('content')

<div class="container">

    <h2>Editar Curso</h2>

    <form action="{{ route('cursos.update',$curso) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label>Área</label>

            <select name="area_id" class="form-control">

                @foreach($areas as $area)

                    <option
                        value="{{ $area->id }}"
                        {{ $curso->area_id == $area->id ? 'selected' : '' }}>

                        {{ $area->nombre }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Nombre</label>

            <input
                type="text"
                name="nombre"
                value="{{ $curso->nombre }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Descripción</label>

            <textarea
                name="descripcion"
                class="form-control">{{ $curso->descripcion }}</textarea>

        </div>

        <div class="mb-3">

            <label>Imagen</label>

            <input
                type="text"
                name="imagen"
                value="{{ $curso->imagen }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Estado</label>

            <select name="estado" class="form-control">

                <option value="1" {{ $curso->estado ? 'selected' : '' }}>
                    Activo
                </option>

                <option value="0" {{ !$curso->estado ? 'selected' : '' }}>
                    Inactivo
                </option>

            </select>

        </div>

        <button class="btn btn-primary">
            Actualizar
        </button>

        <a href="{{ route('cursos.index') }}" class="btn btn-secondary">
            Cancelar
        </a>

    </form>

</div>

@endsection