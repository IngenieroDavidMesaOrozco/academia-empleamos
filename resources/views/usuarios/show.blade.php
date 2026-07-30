@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle del Usuario</h2>
    <p><strong>ID:</strong> {{ $usuario->id }}</p>
    <p><strong>Nombre:</strong> {{ $usuario->name }}</p>
    <p><strong>Email:</strong> {{ $usuario->email }}</p>
    <p><strong>Usuario:</strong> {{ $usuario->username }}</p>
    <p><strong>Perfil:</strong> {{ $usuario->perfil }}</p>
    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
