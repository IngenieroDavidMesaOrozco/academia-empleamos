@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Lista de Usuarios</h2>

        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            + Nuevo Usuario
        </a>
    </div>

    <form method="GET" action="{{ route('usuarios.index') }}" class="mb-3">
        <div class="row g-2">
            <div class="col-md-8">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Buscar usuario...">
            </div>

            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100">
                    Buscar
                </button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">

            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Usuario</th>
                    <th>Roles</th>
                    <th>Estado</th>
                    <th width="280" class="text-center">Acciones</th>
                </tr>
            </thead>

            <tbody>
                @forelse($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->name }}</td>
                        <td>{{ $usuario->email }}</td>
                        <td>{{ $usuario->username }}</td>

                        <td>
                            @foreach($usuario->roles as $rol)
                                <span class="badge bg-primary">
                                    {{ $rol->name }}
                                </span>
                            @endforeach
                        </td>

                        <td>
                            @if($usuario->activo)
                                <span class="badge bg-success">Activo</span>
                            @else
                                <span class="badge bg-secondary">Inactivo</span>
                            @endif
                        </td>

                        <td class="text-center">
                            <a href="{{ route('usuarios.show', $usuario) }}"
                               class="btn btn-sm btn-info text-white me-1">
                                Ver
                            </a>

                            <a href="{{ route('usuarios.edit', $usuario) }}"
                               class="btn btn-sm btn-warning me-1">
                                Editar
                            </a>

                            <form action="{{ route('usuarios.toggleActivo', $usuario) }}"
                                  method="POST"
                                  class="d-inline me-1">
                                @csrf
                                @method('PATCH')

                                <button class="btn btn-sm {{ $usuario->activo ? 'btn-secondary' : 'btn-success' }}">
                                    {{ $usuario->activo ? 'Desactivar' : 'Activar' }}
                                </button>
                            </form>

                            <form action="{{ route('usuarios.destroy', $usuario) }}"
                                  method="POST"
                                  class="d-inline"
                                  onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger">
                                    Eliminar
                                </button>
                            </form>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            No hay usuarios registrados.
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>
    </div>

    {{ $usuarios->links() }}

</div>
@endsection