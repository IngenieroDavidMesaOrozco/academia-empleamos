@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Mensajes de alerta -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i><strong>¡Atención!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Formulario de Evaluación -->
    <div class="card shadow-lg border-0 rounded-4" style="background-color: #121826; color: #fff;">
        <div class="card-header py-3 px-4 border-bottom border-secondary" style="background-color: #1a2234;">
            <h3 class="mb-0 fw-bold text-warning"><i class="fa-solid fa-pen-to-square me-2"></i> Evaluación: {{ $evaluacion->titulo }}</h3>
        </div>
        <div class="card-body p-4 p-md-5">
            
            <form action="{{ route('evaluacion.responder', $evaluacion->id) }}" method="POST">
                @csrf

                @foreach($evaluacion->preguntas as $pregunta)
                    <div class="card mb-4 border border-secondary shadow-sm rounded-3" style="background-color: #1a2234; color: #fff;">
                        <div class="card-header bg-transparent border-bottom border-secondary px-4 py-3">
                            <strong class="fs-5 text-white">
                                {{ $loop->iteration }}. {{ $pregunta->pregunta ?? $pregunta->texto }}
                            </strong>
                        </div>
                        <div class="card-body px-4 py-3">
                            @foreach($pregunta->opciones as $opcion)
                                <div class="form-check mb-3 py-1">
                                    <input 
                                        class="form-check-input bg-dark border-secondary" 
                                        type="radio" 
                                        name="pregunta_{{ $pregunta->id }}" 
                                        value="{{ $opcion->id }}" 
                                        id="opcion_{{ $opcion->id }}"
                                        required>
                                    
                                    <label class="form-check-label fs-6 text-white-50" style="cursor: pointer;" for="opcion_{{ $opcion->id }}">
                                        {{ $opcion->opcion ?? $opcion->texto }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div class="text-center mt-5">
                    <button type="submit" class="btn btn-success btn-lg px-5 py-3 fw-bold shadow rounded-pill">
                        <i class="fa-solid fa-check-circle me-2"></i> Finalizar Evaluación y Generar Certificado
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection