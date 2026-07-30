@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-4">

        <h2>

            📂 Recursos de las Lecciones

        </h2>

        <a href="{{ route('recursos.create') }}"
           class="btn btn-primary">

            ➕ Nuevo Recurso

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="row">

        @forelse($recursos as $recurso)

            <div class="col-md-4">

                <div class="card shadow-sm mb-4">

                    <div class="card-body">

                        <h4>

                            {{ $recurso->nombre }}

                        </h4>

                        <hr>

                        <p>

                            <strong>Lección:</strong>

                            {{ $recurso->leccion->titulo }}

                        </p>

                        <p>

                            <strong>Tipo:</strong>

                            {{ strtoupper($recurso->tipo) }}

                        </p>

                        <a href="{{ asset('storage/'.$recurso->archivo) }}"
                           target="_blank"
                           class="btn btn-success btn-sm">

                            👁 Ver Archivo

                        </a>

                        <a href="{{ route('recursos.edit',$recurso) }}"
                           class="btn btn-warning btn-sm">

                            ✏ Editar

                        </a>

                        <form
                            action="{{ route('recursos.destroy',$recurso) }}"
                            method="POST"
                            class="d-inline">

                            @csrf
                            @method('DELETE')

                            <button
                                onclick="return confirm('¿Eliminar recurso?')"
                                class="btn btn-danger btn-sm">

                                🗑

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        @empty

            <div class="alert alert-info">

                No existen recursos registrados.

            </div>

        @endforelse

    </div>

</div>

@endsection