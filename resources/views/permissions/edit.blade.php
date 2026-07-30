@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Permiso</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('permissions.update', $permission) }}" method="POST">
        @csrf @method('PUT')

        <div class="form-group">
            <label for="name">Nombre del permiso</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $permission->name) }}" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar</button>
        <a href="{{ route('permissions.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
