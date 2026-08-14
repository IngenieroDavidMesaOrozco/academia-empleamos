@extends('layouts.app')

@section('content')
<div class="container py-4">

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-3">
        <i class="fa-solid fa-arrow-left me-1"></i> Volver
    </a>

    <div class="card shadow-sm border-0 bg-dark text-white">

        <div class="card-header bg-primary text-white p-3 border-0">
            <h3 class="mb-0 fw-bold">
                {{ $leccion->titulo }}
            </h3>
        </div>

        <div class="card-body p-4">

            <h5 class="text-info fw-semibold">Descripción</h5>

            <p class="text-light">
                {{ $leccion->descripcion }}
            </p>

            @if($leccion->video)

                <hr class="border-secondary">

                <h5 class="text-warning fw-semibold">Video</h5>

                <div class="ratio ratio-16x9 rounded overflow-hidden border border-secondary">

                    <iframe
                        src="{{ $leccion->video }}"
                        allowfullscreen>
                    </iframe>

                </div>

            @endif

            <hr class="border-secondary">

            <h5 class="text-success fw-semibold">Recursos de la lección</h5>

            @if($leccion->recursos && $leccion->recursos->count())

                <div class="table-responsive">
                    <table class="table table-dark table-hover table-bordered align-middle border-secondary mb-0">

                        <thead class="table-secondary text-dark">

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

                                            <i class="fa-solid fa-download me-1"></i> Descargar

                                        </a>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>
                </div>

            @else

                <div class="alert alert-warning border-0">

                    Esta lección aún no tiene recursos registrados.

                </div>

            @endif

            <hr class="border-secondary">

            <form
                action="{{ route('leccion.completar',$leccion->id) }}"
                method="POST">

                @csrf

                <button
                    class="btn btn-success fw-bold px-4 py-2">

                    ✅ Marcar como completada

                </button>

            </form>

        </div>

    </div>

</div>
@endsection