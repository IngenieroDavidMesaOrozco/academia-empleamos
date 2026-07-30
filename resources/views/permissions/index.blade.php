@extends('layouts.app')

@section('head')
    <link href="{{ asset('css/permisos.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="container gestion-permisos">
    <h2>Lista de Permisos</h2>

    @can('permisos.create')
        <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-3">Crear Permiso</a><br>
    @endcan

    <form method="GET" action="{{ route('permissions.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Buscar usuario..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Buscar</button>
    </form>

    <a href="{{ route('permissions.index') }}" class="btn btn-outline-secondary">Quitar filtros</a><br><br>

    @can('roles.view')
        <a class="btn btn-primary mb-3" href="{{ route('roles.index') }}">Vista Roles</a><br>
    @endcan

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($permisos as $permiso)
                <tr>
                    <td>{{ $permiso->name }}</td>
                    <td>
                        @can('permisos.edit')
                            <a href="{{ route('permissions.edit', $permiso) }}" class="btn btn-sm btn-info">Editar</a>
                        @endcan

                        @can('permisos.delete')
                            <form action="{{ route('permissions.destroy', $permiso) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este permiso?')">Eliminar</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $permisos->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
