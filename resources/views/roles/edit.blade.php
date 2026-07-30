@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Rol</h2>

    {{-- Formulario de búsqueda --}}
    <form method="GET" action="{{ route('roles.edit', $role) }}" class="mb-3">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Buscar permiso...">
    </form>

    {{-- Errores de validación --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario de actualización --}}
    <form action="{{ route('roles.update', $role) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-3">
            <label>Nombre del Rol</label>
            <input type="text" name="name" class="form-control" required value="{{ old('name', $role->name) }}">
        </div>

        <h5>Permisos</h5>

        <div class="row">
            @foreach ($permisos->chunk(10) as $grupo)
                <div class="col-md-2">
                    @foreach ($grupo as $permiso)
                        <div class="form-check mb-1">
                            <input type="checkbox" name="permissions[]" value="{{ $permiso->id }}" class="form-check-input"
                                id="permiso{{ $permiso->id }}"
                                {{ $role->permissions->contains($permiso) ? 'checked' : '' }}>
                            <label class="form-check-label" for="permiso{{ $permiso->id }}">{{ $permiso->name }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar Rol</button>
        <a href="{{ route('roles.index') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
