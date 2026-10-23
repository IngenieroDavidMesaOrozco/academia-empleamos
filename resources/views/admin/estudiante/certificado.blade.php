@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h2 class="mb-0">
                 Certificado de Finalización
            </h2>
        </div>
        <div class="card-body text-center">
            <h3>
                {{ $certificado->usuario->name }}
            </h3>
            <p class="fs-5">
                Ha completado satisfactoriamente el curso
            </p>
            <h2 class="text-primary">
                {{ $certificado->curso->nombre }}
            </h2>
            <hr>
            <p>
                Código del certificado
            </p>
            <h4>
                {{ $certificado->codigo }}
            </h4>
            <p>
                Fecha de emisión
            </p>
            <strong>
                {{ \Carbon\Carbon::parse($certificado->fecha_emision)->format('d/m/Y') }}
            </strong>
            
            <br><br>
            
            <!-- Botón para descargar el PDF -->
            <a href="{{ route('certificado.descargar', $certificado->id) }}" class="btn btn-success mb-2 mx-1">
                Descargar Certificado PDF
            </a>
            
            <!-- Botón para volver al panel -->
            <a href="{{ route('estudiante.dashboard') }}" class="btn btn-primary mb-2 mx-1">
                Volver al panel
            </a>
        </div>
    </div>
</div>
@endsection