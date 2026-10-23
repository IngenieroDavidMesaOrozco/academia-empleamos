@extends('layouts.app')

@section('content')
<div class="container-fluid px-4 py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h3 class="fw-bold text-dark mb-1">Gestión de Lecciones</h3>
            <p class="text-muted small mb-0">Administra el contenido y los materiales interactivos de los módulos.</p>
        </div>
        <a href="{{ route('lecciones.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
            <i class="fa-solid fa-plus me-1"></i> Nueva Lección
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 bg-white">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="70" class="py-3 rounded-start">ID</th>
                            <th class="py-3">Módulo</th>
                            <th class="py-3">Título</th>
                            <th width="90" class="py-3">Orden</th>
                            <th width="320" class="py-3 text-end rounded-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($lecciones as $leccion)
                        <tr>
                            <td class="fw-bold text-muted">#{{ $leccion->id }}</td>
                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-1 rounded-pill">
                                    {{ $leccion->modulo->nombre ?? 'N/D' }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold text-dark">{{ $leccion->titulo }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1">{{ $leccion->orden }}</span>
                            </td>
                            <td class="text-end">
                                <div class="btn-group gap-1">
                                    <a href="{{ route('recursos.index', ['leccion' => $leccion->id]) }}" class="btn btn-outline-info btn-sm rounded-pill px-3">
                                        <i class="fa-solid fa-folder-open me-1"></i> Recursos
                                    </a>
                                    <a href="{{ route('lecciones.edit', $leccion) }}" class="btn btn-outline-warning btn-sm rounded-pill px-3">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Editar
                                    </a>
                                    <form action="{{ route('lecciones.destroy', $leccion) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('¿Desea eliminar esta lección?')" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                            <i class="fa-solid fa-trash me-1"></i> Eliminar
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-5">
                                <i class="fa-solid fa-folder-open fa-2x mb-2 text-secondary opacity-50"></i>
                                <p class="mb-0">No existen lecciones registradas.</p>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection