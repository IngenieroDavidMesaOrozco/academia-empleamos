@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>

Nueva Pregunta

</h3>

</div>

<div class="card-body">

<form action="{{ route('preguntas.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Evaluación</label>

<select
name="evaluacion_id"
class="form-select">

@foreach($evaluaciones as $evaluacion)

<option
value="{{ $evaluacion->id }}"
{{ (isset($evaluacionSeleccionada) && $evaluacionSeleccionada==$evaluacion->id)?'selected':'' }}>

{{ $evaluacion->titulo }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Pregunta</label>

<textarea
name="pregunta"
class="form-control"
rows="4"></textarea>

</div>

<button class="btn btn-success">

Guardar

</button>

<a href="{{ route('preguntas.index') }}"
class="btn btn-secondary">

Cancelar

</a>

</form>

</div>

</div>

</div>

@endsection