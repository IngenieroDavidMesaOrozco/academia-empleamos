@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">
        {{ $curso->nombre }}
    </h2>

    <p>
        {{ $curso->descripcion }}
    </p>

    {{-- BARRA DE PROGRESO --}}
    <div class="card mb-4 shadow">
        <div class="card-body">

            <h5>📊 Progreso del curso</h5>

            <div class="progress" style="height:30px;">
                <div
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="width: {{ $porcentaje }}%;">

                    {{ $porcentaje }}%

                </div>
            </div>

            <br>

            <strong>{{ $leccionesCompletadas }}</strong>
            de
            <strong>{{ $totalLecciones }}</strong>
            lecciones completadas.

        </div>
    </div>

    @foreach($curso->modulos as $modulo)

        {{-- Bloquear módulos si el anterior no está terminado --}}
        @if(!$loop->first)

            @php
                $anterior = $curso->modulos[$loop->index-1];
            @endphp

            @if(!$modulosDesbloqueados[$anterior->id])

                <div class="alert alert-warning">
                    🔒 Este módulo permanece bloqueado hasta completar el módulo anterior.
                </div>

                @continue

            @endif

        @endif

        <div class="card mb-4 shadow">

            <div class="card-header bg-primary text-white">

                <h4>{{ $modulo->nombre }}</h4>

            </div>

            <div class="card-body">

                @if($modulo->descripcion)

                    <p>{{ $modulo->descripcion }}</p>

                @endif

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th width="60">#</th>

                            <th>Lección</th>

                            <th width="180">Acción</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($modulo->lecciones as $leccion)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>

                                {{ $leccion->titulo }}

                                @if(in_array($leccion->id,$completadas))

                                    <span class="badge bg-success">
                                        ✔ Completada
                                    </span>

                                @endif

                            </td>

                            <td>

                                <a
                                    href="{{ route('lecciones.show',$leccion->id) }}"
                                    class="btn btn-primary btn-sm">

                                    Abrir

                                </a>

                                @if(in_array($leccion->id,$completadas))

                                    <span class="badge bg-success">
                                        ✔ Finalizada
                                    </span>

                                @endif

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                {{-- BOTÓN DE EVALUACIÓN DEL MÓDULO --}}
                @if($modulo->evaluacion)

                    @php

                        $terminado = true;

                        foreach($modulo->lecciones as $lec){

                            if(!in_array($lec->id,$completadas)){

                                $terminado = false;

                            }

                        }

                    @endphp

                    <hr>

                    @if($terminado)

                        <a
                            href="{{ route('evaluacion.ver',$modulo->evaluacion->id) }}"
                            class="btn btn-success">

                            📝 Presentar evaluación

                        </a>

                    @else

                        <button
                            class="btn btn-secondary"
                            disabled>

                            🔒 Complete todas las lecciones para presentar la evaluación

                        </button>

                    @endif

                @endif

            </div>

        </div>

    @endforeach

</div>

@endsection