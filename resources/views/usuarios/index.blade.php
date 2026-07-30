@extends('layouts.app')
@section('head')
    <link href="{{ asset('css/usuarios.css') }}" rel="stylesheet">
@endsection
@section('content')
<div class="container gestion-usuarios">
     <a class="btn btn-primary mb-3" href="{{ route('home') }}"><- Volver Home</a><br>
    <h2>Lista de Usuarios</h2>
               

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


  @can('usuarios.create')
    <a href="{{ route('usuarios.create') }}" class="btn btn-primary mb-3">Crear Usuario</a>
@endcan


<form method="GET" action="{{ route('usuarios.index') }}" class="mb-3 d-flex align-items-center flex-wrap gap-2">
    <input type="text" name="search" class="form-control me-2" placeholder="Buscar usuario..." value="{{ request('search') }}">

    <div class="form-check me-2">
        <input 
            type="checkbox" 
            name="estados[]" 
            value="1" 
            id="activos" 
            class="form-check-input"
            {{ in_array('1', request('estados', ['1'])) ? 'checked' : '' }}>
        <label class="form-check-label" for="activos">Activos</label>
    </div>

    <div class="form-check me-2">
        <input 
            type="checkbox" 
            name="estados[]" 
            value="0" 
            id="inactivos" 
            class="form-check-input"
            {{ in_array('0', request('estados', [])) ? 'checked' : '' }}>
        <label class="form-check-label" for="inactivos">Inactivos</label>
    </div>

    <button type="submit" class="btn btn-outline-primary">Buscar</button>
</form>



<a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary">Quitar filtros</a>


    <table class="table table-bordered">
        <thead>
            <tr>
               <!-- <th>ID</th>-->
                <th>Nombre</th>
                <th>Email</th>
                <th>Usuario</th>
                <th>Perfil</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($usuarios as $usuario)
            <tr>
              <!--  <td>{{ $usuario->id }}</td>-->
                <td>{{ $usuario->name }}</td>
                <td>{{ $usuario->email }}</td>
                <td>{{ $usuario->username }}</td>
<td>
    @foreach ($usuario->roles as $rol)
        <span class="badge bg-info text-dark">{{ $rol->name }}</span>
    @endforeach
</td>        



<td>
@can('usuarios.edit')
    <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-warning">Editar</a>
@endcan
<br><br>

@can('usuarios.activos')

    <form action="{{ route('usuarios.toggleActivo', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Deseas cambiar el estado de este usuario?')">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn btn-sm {{ $usuario->activo ? 'btn-success' : 'btn-secondary' }}">
            {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
        </button>
    </form>
@endcan

                <!-- @can('usuarios.delete')
   <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')">Eliminar</button>
    </form>
@endcan-->

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
     <div class="d-flex justify-content-center">
{{ $usuarios->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}</div>

</div>
@endsection
