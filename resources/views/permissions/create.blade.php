@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Permiso</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nombre del permiso</label>
            <input type="text" name="name" class="form-control" required placeholder="Ej: crear-usuario">
        </div>

        <button type="submit" class="btn btn-success mt-3">Guardar</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
