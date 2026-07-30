@extends('layouts.app')

@section('page-title', 'Editar Usuario')

@section('content')

<div class="card p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">Editar Usuario</h3>
            <p class="text-muted mb-0">Actualiza la información y los permisos del usuario.</p>
        </div>

        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
            Volver
        </a>

    </div>

    <form method="POST" action="{{ route('usuarios.update', $usuario) }}">

        @csrf
        @method('PUT')

        <div class="row g-4">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre completo</label>
                <input type="text" name="name" class="form-control" value="{{ $usuario->name }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre de usuario</label>
                <input type="text" name="username" class="form-control" value="{{ $usuario->username }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nueva contraseña (opcional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="col-12">

                <label class="form-label fw-semibold d-block mb-2">Roles</label>

                <div class="card border rounded-4 p-3 bg-light-subtle">

                    @foreach($roles as $rol)

                        <div class="form-check mb-2">

                            <input class="form-check-input"
                                   type="checkbox"
                                   name="roles[]"
                                   value="{{ $rol->id }}"
                                   id="rol_{{ $rol->id }}"
                                   {{ $usuario->roles->contains('id', $rol->id) ? 'checked' : '' }}>

                            <label class="form-check-label fw-medium" for="rol_{{ $rol->id }}">
                                {{ $rol->name }}
                            </label>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>

        <div class="mt-4 d-flex gap-2">

            <button class="btn btn-primary">
                <i class="fa-solid fa-floppy-disk me-2"></i>
                Actualizar Usuario
            </button>

            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection