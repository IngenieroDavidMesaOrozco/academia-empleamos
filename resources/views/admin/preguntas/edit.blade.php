@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning text-dark">

            <h3 class="mb-0">

                ✏️ Editar Pregunta

            </h3>

        </div>

        <div class="card-body">

            <form action="{{ route('preguntas.update', $pregunta) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">

                        Evaluación

                    </label>

                    <select
                        name="evaluacion_id"
                        class="form-select"
                        required>

                        @foreach($evaluaciones as $evaluacion)

                            <option
                                value="{{ $evaluacion->id }}"
                                {{ $pregunta->evaluacion_id == $evaluacion->id ? 'selected' : '' }}>

                                {{ $evaluacion->titulo }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Pregunta

                    </label>

                    <textarea
                        name="pregunta"
                        class="form-control"
                        rows="5"
                        required>{{ old('pregunta', $pregunta->pregunta) }}</textarea>

                </div>

                <button
                    type="submit"
                    class="btn btn-success">

                    💾 Actualizar

                </button>

                <a
                    href="{{ route('preguntas.index') }}"
                    class="btn btn-secondary">

                    Cancelar

                </a>

            </form>

        </div>

    </div>

</div>

@endsection