@extends('layouts.app')
@section('head')
    <link href="{{ asset('css/usuarios.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container gestion-usuarios">
    <h2>Crear Usuario</h2>

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


    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf
        <div class="form-group mb-2">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Correo</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="form-group mb-2">
            <label>Usuario</label>
            <input type="text" name="username" class="form-control" required>
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

    <input type="hidden" name="soporte_it" value="0"> <!-- Este se envía si no se marca el checkbox -->
    <input type="checkbox" class="form-check-input" id="soporte_it" name="soporte_it" value="1"
        {{ old('soporte_it', $user->soporte_it ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="soporte_it">¿Es soporte IT?</label>
</div>



   <div class="form-group mb-2">
    <label>Contraseña</label>
    <input type="password" name="password" class="form-control" required>
</div>

<div class="form-group mb-3">
    <label>Confirmar Contraseña</label>
    <input type="password" name="password_confirmation" class="form-control" required>
</div>


        <button class="btn btn-success">Guardar</button>
         <a class="btn btn-secondary" href="{{ route('usuarios.index') }}"><- Volver</a>
    </form>
</div>
@endsection
