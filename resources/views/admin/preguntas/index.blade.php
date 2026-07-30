@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">

        <h2>❓ Preguntas</h2>

        <a href="{{ route('preguntas.create') }}"
           class="btn btn-primary">

            Nueva Pregunta

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <table class="table table-bordered">

        <thead class="table-dark">

        <tr>

            <th>ID</th>

            <th>Evaluación</th>

            <th>Pregunta</th>

            <th width="250">

                Acciones

            </th>

        </tr>

        </thead>

        <tbody>

        @foreach($preguntas as $pregunta)

            <tr>

                <td>

                    {{ $pregunta->id }}

                </td>

                <td>

                    {{ $pregunta->evaluacion->titulo }}

                </td>

                <td>

                    {{ $pregunta->pregunta }}

                </td>

                <td>

                    <a href="{{ route('preguntas.edit',$pregunta) }}"
                       class="btn btn-warning btn-sm">

                        Editar

                    </a>

                    <a href="{{ route('opciones.index',['pregunta'=>$pregunta->id]) }}"
                       class="btn btn-info btn-sm">

                        Opciones

                    </a>

                    <form
                        action="{{ route('preguntas.destroy',$pregunta) }}"
                        method="POST"
                        class="d-inline">

                        @csrf
                        @method('DELETE')

                        <button
                            class="btn btn-danger btn-sm">

                            Eliminar

                        </button>

                    </form>

                </td>

            </tr>

        @endforeach

        </tbody>

    </table>

</div>

@endsection