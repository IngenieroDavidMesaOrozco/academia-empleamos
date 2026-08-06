@extends('layouts.app')

@section('content')
<style>
    .welcome-card {
        border-radius: 1rem;
        overflow: hidden;
        animation: fadeIn 0.8s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .btn-continue {
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .btn-continue:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(40, 167, 69, 0.3);
    }

    .video-container {
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow-lg border-0 welcome-card">
                <div class="card-body p-5">

                    <div class="text-center mb-5">
                        <div class="mb-4 text-primary">
                            <i class="fa-solid fa-graduation-cap fa-4x"></i>
                        </div>
                        <h1 class="fw-bold text-dark mb-3">¡Bienvenido a la Academia Corporativa!</h1>
                        <p class="text-muted lead px-md-5">
                            Estamos felices de tenerte aquí. Antes de comenzar tu camino de aprendizaje y descubrir tus cursos,
                            por favor tómate un momento para ver este mensaje de bienvenida de nuestro gerente.
                        </p>
                    </div>

                    <div class="ratio ratio-16x9 mb-5 video-container bg-dark">
                        <iframe
                            src="https://www.youtube.com/embed/n9Z5dpGuThM?autoplay=1&rel=0"
                            title="Mensaje del gerente"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen>
                        </iframe>
                    </div>

                    <div class="text-center">
                        <hr class="w-25 mx-auto mb-4 text-muted">
                        <form method="POST" action="{{ route('estudiante.bienvenida.completar') }}" id="welcome-form">
                            @csrf
                            <button type="button" class="btn btn-success btn-lg px-5 py-3 rounded-pill btn-continue fw-bold fs-5" id="continue-btn">
                                <i class="fa-solid fa-check-circle me-2"></i> He visto el mensaje y deseo continuar
                            </button>
                        </form>
                        <small class="d-block text-muted mt-3">Al continuar, serás redirigido para configurar tu contraseña o a tu panel principal.</small>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const btn = document.getElementById('continue-btn');
        const form = document.getElementById('welcome-form');

        btn.addEventListener('click', function() {
            // Añadir un estado de carga visual
            const originalText = this.innerHTML;
            this.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Procesando...';
            this.classList.add('disabled');

            // Enviar formulario tras breve delay para efecto visual
            setTimeout(() => {
                form.submit();
            }, 600);
        });
    });
</script>
@endsection
