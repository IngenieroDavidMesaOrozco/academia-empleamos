@extends('layouts.app')
@section('head')
    <link href="{{ asset('css/usuarios.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container gestion-usuarios">
    <h2>Editar Usuario</h2>

{{-- Mensaje de éxito --}}
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Mensaje de error general --}}
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

{{-- Validaciones individuales (opcional) --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Hubo algunos errores:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group mb-2">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ $usuario->name }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Correo</label>
            <input type="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
        </div>

        <div class="form-group mb-2">
            <label>Usuario</label>
            <input type="text" name="username" class="form-control" value="{{ $usuario->username }}" required>
        </div>
@foreach($roles as $rol)
    @php
        $esSuperAdmin = $rol->name === 'SuperAdmin';
        $usuarioEsSuperAdmin = isset($usuario) && $usuario->hasRole('SuperAdmin');
        $authEsSuperAdmin = auth()->user()->hasRole('SuperAdmin');
    @endphp

    @if(!$esSuperAdmin || $authEsSuperAdmin)
        <div class="form-check">
            <input class="form-check-input"
                   type="checkbox"
                   name="roles[]"
                   value="{{ $rol->id }}"
                   id="rol{{ $rol->id }}"
                   {{ isset($usuario) && $usuario->roles->contains($rol) ? 'checked' : '' }}>
            <label class="form-check-label" for="rol{{ $rol->id }}">{{ $rol->name }}</label>
        </div>
    @endif
@endforeach
<br>
<div class="form-check mb-3">
                    <label>Usuario brinda soporte</label>

    <input type="hidden" name="soporte_it" value="0"> <!-- Se envía si el checkbox no está marcado -->
    <input type="checkbox" class="form-check-input" id="soporte_it" name="soporte_it" value="1"
        {{ old('soporte_it', $usuario->soporte_it) ? 'checked' : '' }}>
    <label class="form-check-label" for="soporte_it">¿Es soporte IT?</label>
</div>


        <div class="form-group mb-3">
            <label>Nueva Contraseña (opcional)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-primary">Actualizar</button>
                 <a class="btn btn-secondary" href="{{ route('usuarios.index') }}"><- Volver</a>

    </form>
</div>
@endsection
