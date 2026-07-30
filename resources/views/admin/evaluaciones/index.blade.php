@extends('layouts.app')

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-4">

<h2>

📝 Gestión de Evaluaciones

</h2>

<a
href="{{ route('evaluaciones.create') }}"
class="btn btn-primary">

Nueva Evaluación

</a>

</div>

@if(session('success'))

<div class="alert alert-success">

{{ session('success') }}

</div>

@endif

<table class="table table-bordered table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Lección</th>

<th>Título</th>

<th>Puntaje</th>

<th>Tiempo</th>

<th>Estado</th>

<th width="220">

Acciones

</th>

</tr>

</thead>

<tbody>

@foreach($evaluaciones as $evaluacion)

<tr>

<td>

{{ $evaluacion->id }}

</td>

<td>

{{ $evaluacion->leccion->titulo }}

</td>

<td>

{{ $evaluacion->titulo }}

</td>

<td>

{{ $evaluacion->puntaje_aprobacion }}

%

</td>

<td>

{{ $evaluacion->tiempo }}

min

</td>

<td>

{{ $evaluacion->estado }}

</td>

<td>

<a
href="{{ route('evaluaciones.edit',$evaluacion) }}"
class="btn btn-warning btn-sm">

Editar

</a>

<form
action="{{ route('evaluaciones.destroy',$evaluacion) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button
class="btn btn-danger btn-sm">

Eliminar

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

@endsection