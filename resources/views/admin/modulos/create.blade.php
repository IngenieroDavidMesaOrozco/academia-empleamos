@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Nuevo Módulo</h2>

    @if($errors->any())

        <div class="alert alert-danger">

            <ul class="mb-0">

                @foreach($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <form action="{{ route('modulos.store') }}" method="POST">

        @csrf

        <div class="mb-3">

            <label class="form-label">
                Curso
            </label>

            <select name="curso_id" class="form-control" required>

                <option value="">Seleccione un curso</option>

                @foreach($cursos as $curso)

                    <option value="{{ $curso->id }}">

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
                value="{{ old('nombre') }}"
                required>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Descripción

            </label>

            <textarea
                name="descripcion"
                class="form-control"
                rows="4">{{ old('descripcion') }}</textarea>

        </div>

        <div class="mb-3">

            <label class="form-label">

                Orden

            </label>

            <input
                type="number"
                name="orden"
                class="form-control"
                value="1"
                required>

        </div>

        <a href="{{ route('modulos.index') }}" class="btn btn-secondary">

            Cancelar

        </a>

        <button class="btn btn-primary">

            Guardar

        </button>

    </form>

</div>

@endsection