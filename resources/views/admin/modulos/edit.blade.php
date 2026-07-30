@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Editar Módulo</h2>

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('modulos.update', $modulo) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label class="form-label">

                Curso

            </label>

            <select name="curso_id" class="form-control" required>

                @foreach($cursos as $curso)

                    <option
                        value="{{ $curso->id }}"
                        {{ $curso->id == $modulo->curso_id ? 'selected' : '' }}>

                        {{ $curso->nombre }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Nombre del módulo

            </label>

            <input
                type="text"
                name="nombre"
                class="form-control"
                value="{{ old('nombre', $modulo->nombre) }}"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Descripción

            </label>

            <textarea
                name="descripcion"
                rows="4"
                class="form-control">{{ old('descripcion', $modulo->descripcion) }}</textarea>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Orden

            </label>

            <input
                type="number"
                name="orden"
                class="form-control"
                value="{{ old('orden', $modulo->orden) }}"
                required>

        </div>

        <a href="{{ route('modulos.index') }}" class="btn btn-secondary">

            Cancelar

        </a>

        <button class="btn btn-primary">

            Actualizar

        </button>

    </form>

</div>

@endsection