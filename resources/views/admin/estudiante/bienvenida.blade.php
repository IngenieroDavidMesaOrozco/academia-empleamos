@extends('layouts.app')

@section('content')
<div class="container py-5">

    <div class="card shadow-lg border-0">

        <div class="card-body p-5 text-center">

            <h2 class="mb-3 fw-bold">🎬 Bienvenido a la Academia Corporativa</h2>

            <p class="text-muted mb-4">
                Antes de comenzar tus cursos, por favor mira el mensaje de bienvenida de nuestro gerente.
            </p>

            <div class="ratio ratio-16x9 mb-4">
                <iframe
                    src="https://www.youtube.com/embed/n9Z5dpGuThM"
                    title="Mensaje del gerente"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen>
                </iframe>
            </div>

            <form method="POST" action="{{ route('estudiante.bienvenida.completar') }}">
                @csrf

                <button class="btn btn-success btn-lg px-5">
                    He visto el mensaje y deseo continuar
                </button>
            </form>

        </div>

    </div>

</div>
@endsection