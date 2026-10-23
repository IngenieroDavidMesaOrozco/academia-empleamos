@extends('layouts.app')

@section('page-title', 'Nuevo Usuario')

@section('content')

<div class="card p-4 shadow-sm border-0 rounded-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-1">Inscribir Nuevo Usuario</h3>
            <p class="text-muted mb-0">Registra al colaborador y el sistema le notificará sus credenciales de acceso por correo.</p>
        </div>

        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
            Volver
        </a>
    </div>

    <form method="POST" action="{{ route('usuarios.store') }}">
        @csrf

        <div class="row g-4">

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre completo</label>
                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Correo electrónico</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre de usuario</label>
                <input type="text" name="username" class="form-control" value="{{ old('username') }}" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Contraseña temporal</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="col-md-6">
                <label class="form-label fw-semibold d-block mb-2">Roles del sistema</label>
                <div class="card border rounded-4 p-3 bg-light-subtle">
                    @foreach($roles as $rol)
                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="roles[]"
                                   value="{{ $rol->id }}"
                                   id="rol_{{ $rol->id }}">

                            <label class="form-check-label fw-medium" for="rol_{{ $rol->id }}">
                                {{ $rol->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="mt-4 d-flex gap-2">
            <button class="btn btn-primary rounded-pill px-4 fw-bold">
                <i class="fa-solid fa-paper-plane me-2"></i>
                Guardar y Enviar Credenciales
            </button>

            <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                Cancelar
            </a>
        </div>

    </form>

</div>

@endsection