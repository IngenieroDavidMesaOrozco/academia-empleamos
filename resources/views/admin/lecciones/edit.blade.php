@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">Editar Lección</h2>

    <form action="{{ route('lecciones.update',$leccion) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="mb-3">

            <label>Módulo</label>

            <select name="modulo_id" class="form-control">

                @foreach($modulos as $modulo)

                    <option
                        value="{{ $modulo->id }}"
                        {{ $leccion->modulo_id==$modulo->id?'selected':'' }}>

                        {{ $modulo->nombre }}

                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-3">

            <label>Título</label>

            <input
                type="text"
                name="titulo"
                value="{{ $leccion->titulo }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Descripción</label>

            <textarea
                name="descripcion"
                class="form-control">{{ $leccion->descripcion }}</textarea>

        </div>

        <div class="mb-3">

            <label>Video</label>

            <input
                type="text"
                name="video"
                value="{{ $leccion->video }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Documento</label>

            <input
                type="text"
                name="documento"
                value="{{ $leccion->documento }}"
                class="form-control">

        </div>

        <div class="mb-3">

            <label>Orden</label>

            <input
                type="number"
                name="orden"
                value="{{ $leccion->orden }}"
                class="form-control">

        </div>

        <button class="btn btn-primary">

            Actualizar

        </button>

    </form>

</div>

@endsection