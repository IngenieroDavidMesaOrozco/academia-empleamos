@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>📚 Gestión de Módulos</h2>

        <a href="{{ route('modulos.create') }}" class="btn btn-primary">
            + Nuevo Módulo
        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="row">

        @forelse($modulos as $modulo)

        <div class="col-md-6 mb-4">

            <div class="card shadow border-0">

                <div class="card-body">

                    <h4>

                        📘 {{ $modulo->nombre }}

                    </h4>

                    <hr>

                    <p>

                        <strong>Curso:</strong>

                        {{ $modulo->curso->nombre }}

                    </p>

                    <p>

                        <strong>Orden:</strong>

                        {{ $modulo->orden }}

                    </p>

                   <div class="d-flex flex-wrap gap-2 mt-3">

    <a href="{{ route('lecciones.index',['modulo'=>$modulo->id]) }}"
       class="btn btn-primary">

        📚 Lecciones

    </a>

    <a href="{{ route('recursos.index') }}"
       class="btn btn-info">

        📂 Recursos

    </a>

    <a href="{{ route('evaluaciones.index') }}"
       class="btn btn-success">

        📝 Evaluaciones

    </a>

    <a href="{{ route('modulos.edit',$modulo) }}"
       class="btn btn-warning">

        ✏ Editar

    </a>

    <form action="{{ route('modulos.destroy',$modulo) }}"
          method="POST">

        @csrf
        @method('DELETE')

        <button class="btn btn-danger">

            🗑

        </button>

    </form>

</div>

        @empty

        <div class="col-12">

            <div class="alert alert-info">

                No existen módulos registrados.

            </div>

        </div>

        @endforelse

    </div>

</div>

@endsection