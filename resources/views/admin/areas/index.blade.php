@extends('layouts.app')

{{-- Título que aparece en la barra superior del panel --}}
@section('page-title', 'Áreas')

@section('content')

<div class="container py-5">

    <!-- =========================================================
         ENCABEZADO DE LA PÁGINA
    ========================================================== -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-1 text-dark fs-3">Gestión de Áreas</h2>
            <p class="text-muted mb-0 small">
                Administra las áreas corporativas de la organización y sus líderes asignados.
            </p>
        </div>

        <!-- Botón para crear una nueva área -->
        <a href="{{ route('areas.create') }}" class="btn btn-primary px-4 py-2.5 rounded-pill shadow-sm fw-semibold d-flex align-items-center gap-2" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); border: none;">
            <i class="fa-solid fa-plus"></i> Nueva Área
        </a>
    </div>

    <!-- =========================================================
         MENSAJE DE ÉXITO
    ========================================================== -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 d-flex align-items-center py-3 px-4">
            <i class="fa-solid fa-circle-check me-3 fs-4 text-success"></i>
            <div class="fw-medium">{{ session('success') }}</div>
        </div>
    @endif

    <!-- =========================================================
         TABLA DE ÁREAS CON DISEÑO EJECUTIVO DE TARJETA
    ========================================================== -->
    @if($areas->count())

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden bg-white">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    
                    <thead class="bg-light text-uppercase text-secondary" style="font-size: 11px; letter-spacing: 1px;">
                        <tr>
                            <th class="py-3 px-4">Líder / Departamento</th>
                            <th class="py-3">Fecha de Creación</th>
                            <th class="py-3 px-4 text-end" width="220">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($areas as $area)
                            <tr style="transition: all 0.2s ease-in-out;">
                                
                                <!-- Foto en formato de Tarjeta Ejecutiva (Evita que se corte) -->
                                <td class="py-4 px-4">
                                    <div class="d-flex align-items-center gap-4">
                                        <!-- Contenedor rectangular con esquinas redondeadas y sombra -->
                                        <div class="shadow-sm border border-2 border-white bg-light rounded-3 overflow-hidden flex-shrink-0 d-flex align-items-center justify-content-center fw-bold text-primary" style="width: 65px; height: 65px;">
                                            @if(!empty($area->foto_lider))
                                                <img src="{{ asset('imagenes/' . $area->foto_lider) }}" alt="Líder" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <span class="fs-5">{{ strtoupper(substr($area->nombre, 0, 2)) }}</span>
                                            @endif
                                        </div>
                                        
                                        <div>
                                            <div class="fw-bold text-dark fs-5 mb-1">
                                                {{ $area->nombre }}
                                            </div>
                                            <span class="badge bg-light text-secondary border px-2 py-1 fw-semibold" style="font-size: 10px; letter-spacing: 0.5px;">
                                                <i class="fa-solid fa-briefcase me-1 text-primary"></i> DEPARTAMENTO CORPORATIVO
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <!-- Fecha de creación -->
                                <td class="text-secondary fw-medium fs-6">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-regular fa-calendar-days text-muted"></i>
                                        <span>{{ $area->created_at->format('d/m/Y') }}</span>
                                    </div>
                                </td>

                                <!-- Acciones Estilizadas -->
                                <td class="text-end py-4 px-4 text-nowrap">
                                    <div class="d-inline-flex gap-2">
                                        <a href="{{ route('areas.edit', $area) }}" class="btn btn-sm btn-light text-primary border px-3 py-2 rounded-pill fw-semibold shadow-sm transition-all" style="border-color: #cbd5e1 !important;">
                                            <i class="fa-solid fa-pen me-1"></i> Editar
                                        </a>

                                        <form id="delete-form-{{ $area->id }}" action="{{ route('areas.destroy', $area) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-sm btn-light text-danger border px-3 py-2 rounded-pill fw-semibold shadow-sm transition-all" style="border-color: #cbd5e1 !important;" onclick="confirmarEliminacion({{ $area->id }})">
                                                <i class="fa-solid fa-trash me-1"></i> Eliminar
                                            </button>
                                        </form>
                                    </div>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>

    @else

        <!-- =========================================================
             ESTADO VACÍO ELEGANTE
        ========================================================== -->
        <div class="card border-0 shadow-sm rounded-4 text-center py-5 bg-white">
            <div class="card-body py-5">
                <div class="mb-3 text-primary opacity-75">
                    <i class="fa-solid fa-building-columns fa-4x"></i>
                </div>
                <h4 class="fw-bold text-dark">No hay áreas registradas</h4>
                <p class="text-muted small mb-4 col-md-6 mx-auto">
                    Comienza registrando la primera área de la organización para estructurar y organizar los cursos corporativos de forma profesional.
                </p>
                <a href="{{ route('areas.create') }}" class="btn btn-primary px-4 py-2.5 rounded-pill fw-semibold shadow-sm">
                    <i class="fa-solid fa-plus me-2"></i> Crear primera área
                </a>
            </div>
        </div>

    @endif

</div>

<!-- SCRIPT DE SWEETALERT2 PARA ELIMINAR -->
<script>
    function confirmarEliminacion(id) {
        Swal.fire({
            title: '¿Está seguro?',
            text: "¡Esta acción eliminará el área y sus cursos asociados permanentemente!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1e3a8a', 
            cancelButtonColor: '#64748B',  
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#ffffff',         
            color: '#0f172a'               
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }
</script>

<style>
    .table tbody tr {
        transition: all 0.2s ease-in-out;
    }
    .table tbody tr:hover {
        background-color: #f8fafc !important;
        transform: scale(1.002);
    }
    .transition-all:hover {
        transform: translateY(-1px);
        opacity: 0.95;
    }
</style>

@endsection