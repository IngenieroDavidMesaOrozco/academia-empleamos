@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h3 class="mb-0">
                📝 Nueva Evaluación
            </h3>

        </div>

        <div class="card-body">

            <form action="{{ route('evaluaciones.store') }}" method="POST">

                @csrf

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
                                value="{{ $modulo->id }}">

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
                        class="form-control"></textarea>

                </div>

                <div class="row">

                    <div class="col-md-6">

                        <label class="form-label">
                            Puntaje de aprobación
                        </label>

                        <input
                            type="number"
                            name="puntaje_aprobacion"
                            value="80"
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
                            value="30"
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

                        <option value="Activo">
                            Activo
                        </option>

                        <option value="Inactivo">
                            Inactivo
                        </option>

                    </select>

                </div>
                {{-- SECCIÓN AGREGADA: PREGUNTAS Y OPCIONES INTEGRADAS --}}
                <hr class="my-4">
                <h4 class="fw-bold text-dark mb-3">❓ Preguntas de la Evaluación</h4>

                <div class="card p-3 mb-3 bg-light border">
                    <label class="form-label fw-bold">Pregunta 1</label>
                    <input type="text" name="preguntas[0][texto]" class="form-control mb-3" placeholder="Ej: ¿Cuál es el uso principal del equipo de protección personal?" required>

                    <label class="form-label text-muted small fw-bold">Opciones de Respuesta (Selecciona la correcta):</label>
                    
                    <div class="input-group mb-2">
                        <div class="input-group-text">
                            <input type="radio" name="preguntas[0][correcta]" value="0" checked>
                        </div>
                        <input type="text" name="preguntas[0][opciones][0]" class="form-control" placeholder="Opción A" required>
                    </div>

                    <div class="input-group mb-2">
                        <div class="input-group-text">
                            <input type="radio" name="preguntas[0][correcta]" value="1">
                        </div>
                        <input type="text" name="preguntas[0][opciones][1]" class="form-control" placeholder="Opción B" required>
                    </div>

                    <div class="input-group mb-2">
                        <div class="input-group-text">
                            <input type="radio" name="preguntas[0][correcta]" value="2">
                        </div>
                        <input type="text" name="preguntas[0][opciones][2]" class="form-control" placeholder="Opción C" required>
                    </div>
                </div>
                
                <div class="mt-4">

                    <button
                        type="submit"
                        class="btn btn-success">

                        💾 Guardar Evaluación

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