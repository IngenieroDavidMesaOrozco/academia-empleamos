@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Configuración del Sistema</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('parametros.update') }}">
        @csrf

        <div class="mb-3">
            <label for="tiempo_para_cambio_contraseña" class="form-label">
                Días permitidos entre cada cambio obligatorio de contraseña
            </label>
            <input type="number" name="tiempo_para_cambio_contraseña" class="form-control" min="1" max="365"
                   value="{{ old('tiempo_para_cambio_contraseña', $parametro->tiempo_para_cambio_contraseña) }}" required>
        </div>
     @can('parametros.edit')

        <button type="submit" class="btn btn-primary">Guardar</button>
     @endcan

    </form><br>
                 <a class="btn btn-primary mb-3" href="{{ route('home') }}"><- Volver Home</a>

</div>
@endsection
