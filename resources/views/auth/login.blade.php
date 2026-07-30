<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia Empleamos</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login-empleamos.css') }}">
</head>
<body>

<div class="bg-shape shape-1"></div>
<div class="bg-shape shape-2"></div>

<div class="login-page">

    <div class="brand-panel">

        <div class="logo-circle">
            <img src="{{ asset('imagenes/logoET.png') }}" alt="Empleamos">
        </div>

        <h1>Academia Empleamos</h1>

        <p>
            Capacitación, seguridad, tecnología y desarrollo humano en una sola experiencia.
        </p>

        <div class="feature-list">

            <div class="feature-item">
                <i class="fa-solid fa-rocket"></i>
                <span>Inducción corporativa</span>
            </div>

            <div class="feature-item">
                <i class="fa-solid fa-shield-heart"></i>
                <span>Seguridad y Salud</span>
            </div>

            <div class="feature-item">
                <i class="fa-solid fa-microchip"></i>
                <span>Tecnología y procesos</span>
            </div>

        </div>

    </div>

    <div class="form-panel">

        <div class="form-card">

            <div class="owl-mascot" id="owl">

                <div class="owl-head">

                    <div class="owl-ear left"></div>
                    <div class="owl-ear right"></div>

                    <div class="owl-eyes">

                        <div class="eye left-eye">
                            <div class="pupil"></div>
                        </div>

                        <div class="eye right-eye">
                            <div class="pupil"></div>
                        </div>

                    </div>

                    <div class="owl-hands">

                        <div class="hand left-hand"></div>
                        <div class="hand right-hand"></div>

                    </div>

                    <div class="owl-beak"></div>

                </div>

            </div>

            <div class="form-header">
                <h2>Iniciar sesión</h2>
                <p>Accede a tu espacio de aprendizaje corporativo</p>
            </div>

            @if(session('error'))
                <div class="alert-login">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group input-wrap">

                    <label for="login">Correo o usuario</label>

                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <input id="login"
                           type="text"
                           name="login"
                           value="{{ old('login') }}"
                           required
                           autofocus
                           class="form-control @error('login') is-invalid @enderror"
                           placeholder="usuario o correo">

                    @error('login')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                </div>

                <div class="form-group input-wrap">

                    <label for="password">Contraseña</label>

                    <div class="input-icon">
                        <i class="fa-solid fa-lock"></i>
                    </div>

                    <input id="password"
                           type="password"
                           name="password"
                           required
                           class="form-control @error('password') is-invalid @enderror"
                           placeholder="••••••••">

                    <button type="button" class="toggle-password">
                        <i class="fa-solid fa-eye"></i>
                    </button>

                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                </div>

                <button type="submit" class="btn-login">
                    <span>Ingresar</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>

            </form>

            <div class="footer-links">
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

        </div>

    </div>

</div>

<script src="{{ asset('js/login-empleamos.js') }}"></script>

</body>
</html>