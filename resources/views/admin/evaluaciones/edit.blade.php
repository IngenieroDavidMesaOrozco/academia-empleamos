@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h3>
                ✏️ Editar Evaluación
            </h3>

        </div>

        <div class="card-body">

            <form action="{{ route('evaluaciones.update', $evaluacion) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Módulo
                    </label>

                    <select
                        name="modulo_id"
                        class="form-select"
                        required>

                        @foreach($modulos as $modulo)

                            <option
                                value="{{ $modulo->id }}"
                                {{ $evaluacion->modulo_id == $modulo->id ? 'selected' : '' }}>

                                {{ $modulo->curso->nombre }}
                                -
                                {{ $modulo->nombre }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Título
                    </label>

                    <input
                        type="text"
                        name="titulo"
                        value="{{ old('titulo', $evaluacion->titulo) }}"
                        class="form-control"
                        required>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Descripción
                    </label>

                    <textarea
                        name="descripcion"
                        rows="4"
                        class="form-control">{{ old('descripcion', $evaluacion->descripcion) }}</textarea>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <label class="form-label">
                            Puntaje de aprobación
                        </label>

                        <input
                            type="number"
                            name="puntaje_aprobacion"
                            value="{{ old('puntaje_aprobacion', $evaluacion->puntaje_aprobacion) }}"
                            class="form-control"
                            required>

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Tiempo (minutos)
                        </label>

                        <input
                            type="number"
                            name="tiempo"
                            value="{{ old('tiempo', $evaluacion->tiempo) }}"
                            class="form-control"
                            required>

                    </div>

                </div>

                <div class="mt-3">

                    <label class="form-label">
                        Estado
                    </label>

                    <select
                        name="estado"
                        class="form-select">

                        <option
                            value="Activo"
                            {{ $evaluacion->estado == 'Activo' ? 'selected' : '' }}>

                            Activo

                        </option>

                        <option
                            value="Inactivo"
                            {{ $evaluacion->estado == 'Inactivo' ? 'selected' : '' }}>

                            Inactivo

                        </option>

                    </select>

                </div>

                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-primary">

                        💾 Actualizar Evaluación

                    </button>

                    <a
                        href="{{ route('evaluaciones.index') }}"
                        class="btn btn-secondary">

                        Cancelar

                    </a>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection