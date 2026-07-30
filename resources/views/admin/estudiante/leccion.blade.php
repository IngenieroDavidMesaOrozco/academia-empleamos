@extends('layouts.app')

@section('content')

<div class="container">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-secondary mb-3">
        ← Volver
    </a>

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3 class="mb-0">
                {{ $leccion->titulo }}
            </h3>

        </div>

        <div class="card-body">

            <h5>Descripción</h5>

            <p>
                {{ $leccion->descripcion }}
            </p>

            @if($leccion->video)

                <hr>

                <h5>Video</h5>

                <div class="ratio ratio-16x9">

                    <iframe
                        src="{{ $leccion->video }}"
                        allowfullscreen>
                    </iframe>

                </div>

            @endif

            <hr>

            <h5>Recursos de la lección</h5>

            @if($leccion->recursos->count())

                <table class="table table-bordered">

                    <thead class="table-light">

                        <tr>

                            <th>Título</th>
                            <th>Tipo</th>
                            <th width="180">Acción</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($leccion->recursos as $recurso)

                            <tr>

                                <td>{{ $recurso->titulo }}</td>

                                <td>{{ ucfirst($recurso->tipo) }}</td>

                                <td>

                                    <a
                                        href="{{ asset('storage/'.$recurso->archivo) }}"
                                        target="_blank"
                                        class="btn btn-success btn-sm">

                                        Descargar

                                    </a>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="alert alert-warning">

                    Esta lección aún no tiene recursos registrados.

                </div>

            @endif

            <hr>

            <form
                action="{{ route('leccion.completar',$leccion->id) }}"
                method="POST">

                @csrf

                <button
                    class="btn btn-success">

                    ✅ Marcar como completada

                </button>

            </form>

        </div>

    </div>

</div>

@endsection