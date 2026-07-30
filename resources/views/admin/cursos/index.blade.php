@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between mb-3">

        <h2>Gestión de Cursos</h2>

        <a href="{{ route('cursos.create') }}" class="btn btn-primary">
            Nuevo Curso
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table align-middle table-hover"> <thead class="table-light"> <tr> <th>Área</th> <th>Curso</th> <th>Estado</th> <th class="text-end" width="220">Acciones</th> </tr> </thead> <tbody> @forelse($cursos as $curso) <tr> <td> <span class="badge bg-primary-subtle text-primary px-3 py-2"> {{ $curso->area->nombre ?? 'Sin área' }} </span> </td> <td class="fw-semibold"> {{ $curso->nombre }} </td> <td> @if($curso->estado) <span class="badge bg-success px-3 py-2">Activo</span> @else <span class="badge bg-secondary px-3 py-2">Inactivo</span> @endif </td> <td class="text-end"> <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-sm btn-outline-primary me-2"> <i class="fa-solid fa-pen me-1"></i> Editar </a> <form action="{{ route('cursos.destroy', $curso) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar este curso?')"> @csrf @method('DELETE') <button type="submit" class="btn btn-sm btn-outline-danger"> <i class="fa-solid fa-trash me-1"></i> Eliminar </button> </form> </td> </tr> @empty <tr> <td colspan="4" class="text-center text-muted py-4"> No existen cursos registrados. </td> </tr> @endforelse </tbody> </table>

</div>

@endsection