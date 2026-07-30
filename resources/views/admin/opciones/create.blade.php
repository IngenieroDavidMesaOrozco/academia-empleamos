@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>Nueva Opción</h3>

</div>

<div class="card-body">

<form action="{{ route('opciones.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Pregunta</label>

<select name="pregunta_id" class="form-select">

@foreach($preguntas as $pregunta)

<option value="{{ $pregunta->id }}"
{{ (isset($preguntaSeleccionada) && $preguntaSeleccionada==$pregunta->id)?'selected':'' }}>

{{ Str::limit($pregunta->pregunta,70) }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Texto de la opción</label>

<input
type="text"
name="opcion"
class="form-control">

</div>

<div class="form-check mb-4">

<input
class="form-check-input"
type="checkbox"
name="es_correcta"
value="1">

<label class="form-check-label">

Es la respuesta correcta

</label>

</div>

<button class="btn btn-success">

Guardar

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