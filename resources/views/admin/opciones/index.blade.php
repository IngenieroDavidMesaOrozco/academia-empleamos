@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-4">

        <h2>✅ Opciones de Respuesta</h2>

        <a href="{{ route('opciones.create') }}" class="btn btn-primary">
            Nueva opción
        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <table class="table table-bordered table-hover">

        <thead class="table-dark">

            <tr>

                <th>ID</th>

                <th>Pregunta</th>

                <th>Opción</th>

                <th>Correcta</th>

                <th width="220">Acciones</th>

            </tr>

        </thead>

        <tbody>

        @forelse($opciones as $opcion)

            <tr>

                <td>{{ $opcion->id }}</td>

                <td>{{ Str::limit($opcion->pregunta->pregunta,40) }}</td>

                <td>{{ $opcion->opcion }}</td>

                <td>

                    @if($opcion->es_correcta)

                        <span class="badge bg-success">
                            Sí
                        </span>

                    @else

                        <span class="badge bg-danger">
                            No
                        </span>

                    @endif

                </td>

                <td>

                    <a href="{{ route('opciones.edit',$opcion) }}"
                       class="btn btn-warning btn-sm">

                        Editar

                    </a>

                    <a href="{{ route('opciones.create',['pregunta'=>$pregunta->id]) }}"
                    class="btn btn-info btn-sm">

                    Opciones

                        </a>

                    <form action="{{ route('opciones.destroy',$opcion) }}"
                          method="POST"
                          class="d-inline">

                        @csrf

                        @method('DELETE')

                        <button class="btn btn-danger btn-sm">

                            Eliminar

                        </button>

                    </form>

                </td>

            </tr>

        @empty

            <tr>

                <td colspan="5" class="text-center">

                    No existen opciones registradas.

                </td>

            </tr>

        @endforelse

        </tbody>

    </table>

</div>

@endsection