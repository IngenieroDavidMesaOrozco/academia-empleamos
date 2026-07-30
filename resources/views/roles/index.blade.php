@extends('layouts.app')
@section('head')
    <link href="{{ asset('css/roles.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container gestion-roles">
    <h2>Roles</h2>

    {{-- Botón crear rol --}}
    @can('roles.create')
        <a class="btn btn-primary mb-3" href="{{ route('roles.create') }}">Nuevo Rol</a><br>
    @endcan

    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Quitar filtros</a><br><br>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Buscador --}}
    <form method="GET" action="{{ route('roles.index') }}" class="mb-3 d-flex">
        <input type="text" name="search" class="form-control me-2" placeholder="Buscar usuario..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-outline-primary">Buscar</button>
    </form>

    {{-- Botón vista permisos --}}
    @can('permisos.view')
        <a class="btn btn-primary mb-3" href="{{ route('permissions.index') }}">Vista permisos</a>
    @endcan

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Tabla de roles --}}
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Permisos</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @foreach($roles as $rol)
            <tr>
                <td>{{ $rol->name }}</td>
                <td>{{ $rol->permissions->pluck('name')->implode(', ') ?: '—' }}</td>
                <td>
                    @can('roles.edit')
                        <a class="btn btn-sm btn-info" href="{{ route('roles.edit', $rol) }}">Editar</a>
                    @endcan

                    @can('roles.delete')
                        <form action="{{ route('roles.destroy', $rol) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar?')">Eliminar</button>
                        </form>
                    @endcan
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a class="btn btn-primary mb-3" href="{{ route('home') }}"><- Volver Home</a><br>

    <div class="d-flex justify-content-center">
        {{ $roles->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
