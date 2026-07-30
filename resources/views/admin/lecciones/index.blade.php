@extends('layouts.app')

@section('content')

<div class="container">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>📖 Gestión de Lecciones</h2>

        <a href="{{ route('lecciones.create') }}" class="btn btn-primary">

            ➕ Nueva Lección

        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card shadow">

        <div class="card-body">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th width="70">ID</th>

                        <th>Módulo</th>

                        <th>Título</th>

                        <th width="80">Orden</th>

                        <th width="420">Acciones</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($lecciones as $leccion)

                    <tr>

                        <td>

                            {{ $leccion->id }}

                        </td>

                        <td>

                            <span class="badge bg-primary">

                                {{ $leccion->modulo->nombre }}

                            </span>

                        </td>

                        <td>

                            <strong>

                                {{ $leccion->titulo }}

                            </strong>

                        </td>

                        <td>

                            {{ $leccion->orden }}

                        </td>

                        <td>

                            <div class="btn-group">

                                <a href="{{ route('recursos.index',['leccion'=>$leccion->id]) }}"
                                   class="btn btn-info btn-sm">

                                    📂 Recursos

                                </a>

                                <a href="{{ route('lecciones.edit',$leccion) }}"
                                   class="btn btn-warning btn-sm">

                                    ✏ Editar

                                </a>

                                <form action="{{ route('lecciones.destroy',$leccion) }}"
                                      method="POST"
                                      style="display:inline;">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        onclick="return confirm('¿Desea eliminar esta lección?')"
                                        class="btn btn-danger btn-sm">

                                        🗑 Eliminar

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5" class="text-center">

                            No existen lecciones registradas.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection