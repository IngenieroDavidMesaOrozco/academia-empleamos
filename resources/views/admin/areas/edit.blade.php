//Hace exactamente lo mismo que create.

//Pero ya trae los datos.

//Por ejemplo: Muestra el formulario para editar

@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">

            <h3>Editar Área</h3>

        </div>

        <div class="card-body">

            @if($errors->any())

                <div class="alert alert-danger">

                    <ul>

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif

            <form action="{{ route('areas.update', $area) }}" method="POST">

                @csrf

                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">

                        Nombre del área

                    </label>

                    <input
                        type="text"
                        name="nombre"
                        class="form-control"
                        value="{{ old('nombre', $area->nombre) }}">

                </div>

                <a href="{{ route('areas.index') }}" class="btn btn-secondary">

                    Cancelar

                </a>

                <button class="btn btn-primary">

                    Actualizar

                </button>

            </form>

        </div>

    </div>

</div>

@endsection