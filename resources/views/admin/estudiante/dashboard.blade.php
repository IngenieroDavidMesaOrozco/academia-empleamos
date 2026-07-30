@extends('layouts.app')

@section('content')

<div class="container">

    <h2 class="mb-4">

        🎓 Mis Cursos

    </h2>

    <div class="row">

        @foreach($cursos as $curso)

            <div class="col-md-4 mb-4">

                <div class="card shadow h-100">

                    <div class="card-body">

                        <h4>

                            {{ $curso->nombre }}

                        </h4>

                        <p>

                            {{ $curso->descripcion }}

                        </p>

                        <p>

                            Módulos:

                            <strong>

                                {{ $curso->modulos->count() }}

                            </strong>

                        </p>

                        <a
                            href="{{ route('estudiante.curso',$curso->id) }}"
                            class="btn btn-primary w-100 mb-2">

                            📖 Continuar Curso

                        </a>

                        @if(isset($certificados[$curso->id]))

                            <a
                                href="{{ route('certificados.descargar',$certificados[$curso->id]) }}"
                                class="btn btn-success w-100">

                                🎓 Descargar Certificado

                            </a>

                        @endif

                    </div>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection