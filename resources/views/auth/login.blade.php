<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Academia Virtual | Empleamos Temporales S.A.S</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login-empleamos.css') }}">
    
    <style>
        .brand-panel {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3.5rem;
        }
        .logo-circle-fix {
            background-color: #ffffff;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            overflow: hidden;
            border: 4px solid rgba(255, 255, 255, 0.3);
        }
        .logo-circle-fix img {
            width: 75%;
            height: auto;
            object-fit: contain;
        }
        .brand-panel h1 {
            font-size: 2.4rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            line-height: 1.1;
            letter-spacing: -0.5px;
        }
        .brand-subtitle {
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 700;
            color: #93c5fd;
            margin-bottom: 1rem;
        }
        .brand-panel p {
            font-size: 1.05rem;
            opacity: 0.9;
            margin-bottom: 2.5rem;
            line-height: 1.5;
        }
        .feature-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 0.8rem;
            padding: 12px 18px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }
        .feature-item:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateX(5px);
        }
        .feature-item i {
            font-size: 1.1rem;
            width: 25px;
            text-align: center;
            color: #93c5fd;
        }
    </style>
</head>
<body>

<div class="bg-shape shape-1"></div>
<div class="bg-shape shape-2"></div>

<div class="login-page">

    <!-- PANEL IZQUIERDO: IDENTIDAD CORPORATIVA -->
    <div class="brand-panel">
        
       <div class="logo-circle-fix">
    <img src="{{ asset("imagenes/ContenidoCurso/logo-empleamos-job.png") }}" alt="Logo Empleamos Temporales">
</div>

        <span class="brand-subtitle">Plataforma de Inducción</span>
        <h1>Empleamos Temporales S.A.S</h1>

        <p>
            Fortalecemos el talento humano mediante experiencias de aprendizaje interactivas. 
        </p>

        <div class="feature-list">
            <div class="feature-item">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>Inducción y Cursos Corporativos</span>
            </div>
            <div class="feature-item">
                <i class="fa-solid fa-award"></i>
                <span>Certificación Automática</span>
            </div>
        </div>

    </div>

    <!-- PANEL DERECHO: ACCESO AL SISTEMA -->
    <div class="form-panel">
        <div class="form-card">

            <div class="owl-mascot" id="owl">
                <div class="owl-head">
                    <div class="owl-ear left"></div>
                    <div class="owl-ear right"></div>
                    <div class="owl-eyes">
                        <div class="eye left-eye"><div class="pupil"></div></div>
                        <div class="eye right-eye"><div class="pupil"></div></div>
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
            </div>

            @if(session('error'))
                <div class="alert-login" style="background-color: #fee2e2; color: #dc2626; padding: 12px; border-radius: 8px; margin-bottom: 20px; text-align: center; font-weight: bold; font-size: 0.9rem;">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group input-wrap">
                    <label for="login" style="font-weight: 600; margin-bottom: 6px; display: block; font-size: 0.9rem; color: #374151;">Correo o usuario</label>
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
                           placeholder="Ingresa tu usuario o correo">           
                    @error('login')
                        <span class="invalid-feedback" style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group input-wrap" style="margin-top: 20px;">
                    <label for="password" style="font-weight: 600; margin-bottom: 6px; display: block; font-size: 0.9rem; color: #374151;">Contraseña</label>
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
                        <span class="invalid-feedback" style="color: #dc2626; font-size: 0.85rem; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-login" style="margin-top: 30px; width: 100%;">
                    <span>Ingresar a la plataforma</span>
             <!-- /* <i class="fa-solid fa-arrow-right"></i>  -- Esta linea nos da un boton con flecha incluida, quitar si les gusta por estetico */-->      
                </button>
            </form>

            <div class="footer-links" style="margin-top: 25px; text-align: center;">
                @if(Route::has('password.request'))
                    <a href="{{ route('password.request') }}" style="color: #6b7280; text-decoration: none; font-size: 0.9rem;">¿Olvidaste tu contraseña?</a>
                @endif
            </div>

        </div>
    </div>
</div>

<script src="{{ asset('js/login-empleamos.js') }}"></script>

</body>
</html>