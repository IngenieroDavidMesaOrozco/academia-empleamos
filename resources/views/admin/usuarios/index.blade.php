@extends('layouts.app')

@section('page-title', 'Gestión de Usuarios')

@section('content')
<div class="container-fluid px-0">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Gestión de Usuarios</h2>
            <p class="text-muted mb-0">Administra los usuarios del sistema, sus roles y estados.</p>
        </div>

        <a href="{{ route('usuarios.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-user-plus me-2"></i> Nuevo Usuario
        </a>
    </div>

    <!-- Buscador -->
    <form method="GET" action="{{ route('usuarios.index') }}" class="mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       class="form-control"
                       placeholder="Buscar por nombre o correo...">
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-primary w-100">
                    <i class="fa-solid fa-search me-1"></i> Buscar
                </button>
            </div>
        </div>
    </form>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="ps-3">Nombre</th>
                        <th>Email</th>
                        <th>Usuario</th>
                        <th>Roles</th>
                        <th>Estado</th>
                        <th width="280" class="text-center pe-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usuarios as $usuario)
                        <tr>
                            <td class="ps-3 fw-semibold">{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ $usuario->username }}</td>
                            <td>
                                @foreach($usuario->roles as $rol)
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">
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
                            <td class="text-center pe-3 text-nowrap">
                                <a href="{{ route('usuarios.show', $usuario) }}"
                                   class="btn btn-sm btn-outline-info me-1" title="Ver detalles">
                                    <i class="fa-solid fa-eye"></i>
                                </a>

                                <a href="{{ route('usuarios.edit', $usuario) }}"
                                   class="btn btn-sm btn-outline-primary me-1" title="Editar usuario">
                                    <i class="fa-solid fa-pen"></i>
                                </a>

                                <form action="{{ route('usuarios.toggleActivo', $usuario) }}"
                                      method="POST"
                                      class="d-inline me-1">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm {{ $usuario->activo ? 'btn-outline-secondary' : 'btn-outline-success' }}" title="{{ $usuario->activo ? 'Desactivar' : 'Activar' }}">
                                        <i class="fa-solid {{ $usuario->activo ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                    </button>
                                </form>

                                <form action="{{ route('usuarios.destroy', $usuario) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger" title="Eliminar usuario">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-users-slash fa-2x mb-2 d-block"></i>
                                No hay usuarios registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $usuarios->links() }}
    </div>

</div>
@endsection