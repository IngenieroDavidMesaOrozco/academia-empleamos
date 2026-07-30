@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3>{{ $evaluacion->titulo }}</h3>

        </div>

        <div class="card-body">

            <form action="{{ route('evaluacion.responder',$evaluacion) }}" method="POST">

                @csrf

                @foreach($evaluacion->preguntas as $pregunta)

                    <div class="card mb-4">

                        <div class="card-header">

                            <strong>

                                {{ $loop->iteration }}.

                                {{ $pregunta->pregunta }}

                            </strong>

                        </div>

                        <div class="card-body">

                            @foreach($pregunta->opciones as $opcion)

                                <div class="form-check">

                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="pregunta_{{ $pregunta->id }}"
                                        value="{{ $opcion->id }}"
                                        required>

                                    <label class="form-check-label">

                                        {{ $opcion->opcion }}

                                    </label>

                                </div>

                            @endforeach

                        </div>

                    </div>

                @endforeach

                <button
                    class="btn btn-success">

                    Finalizar Evaluación

                </button>

            </form>

        </div>

    </div>

</div>

@endsection