@extends('layouts.app')

@section('page-title', 'Áreas')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Gestión de Áreas</h2>
            <p class="text-muted mb-0">
                Administra las áreas de la empresa y organiza los cursos.
            </p>
        </div>

        <a href="{{ route('areas.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus me-2"></i>
            Nueva Área
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if($areas->count())
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th width="80">ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th width="150">Recursos</th>
                            <th width="180">Fecha de creación</th>
                            <th width="220">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($areas as $area)
                            <tr>
                                <td class="fw-semibold">{{ $area->id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $area->nombre }}</div>
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($area->descripcion, 50) }}</small>
                                </td>
                                <td>
                                    @if($area->video)
                                        <a href="{{ $area->video }}" target="_blank" class="badge bg-danger text-decoration-none">
                                            <i class="fa-brands fa-youtube"></i> Video
                                        </a>
                                    @endif
                                    @if($area->archivo_diapositivas)
                                        <a href="{{ asset('storage/' . $area->archivo_diapositivas) }}" target="_blank" class="badge bg-info text-decoration-none text-dark">
                                            <i class="fa-solid fa-file-pdf"></i> Slides
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $area->created_at->format('d/m/Y') }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('areas.edit', $area) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-pen me-1"></i> Editar
                                    </a>
                                    <form action="{{ route('areas.destroy', $area) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Está seguro de eliminar esta área?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-info border-0 shadow-sm text-center py-4">
            <i class="fa-solid fa-building fa-2x mb-3 d-block"></i>
            <h5 class="fw-bold">No hay áreas registradas</h5>
            <p class="mb-0">Crea la primera área para comenzar a organizar los cursos.</p>
        </div>
    @endif
</div>

@endsection
