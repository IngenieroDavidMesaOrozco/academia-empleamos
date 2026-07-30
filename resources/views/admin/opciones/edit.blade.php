@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>Editar Opción</h3>

</div>

<div class="card-body">

<form action="{{ route('opciones.update',$opcion) }}" method="POST">

@csrf

@method('PUT')

<div class="mb-3">

<label>Pregunta</label>

<select
name="pregunta_id"
class="form-select">

@foreach($preguntas as $pregunta)

<option
value="{{ $pregunta->id }}"
{{ $opcion->pregunta_id==$pregunta->id?'selected':'' }}>

{{ Str::limit($pregunta->pregunta,70) }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Opción</label>

<input
type="text"
name="opcion"
value="{{ $opcion->opcion }}"
class="form-control">

</div>

<div class="form-check mb-4">

<input
type="checkbox"
class="form-check-input"
name="es_correcta"
value="1"
{{ $opcion->es_correcta?'checked':'' }}>

<label class="form-check-label">

Respuesta correcta

</label>

</div>

<button class="btn btn-success">

Actualizar

</button>

<a href="{{ route('opciones.index') }}"
class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

</div>

</div>

@endsection