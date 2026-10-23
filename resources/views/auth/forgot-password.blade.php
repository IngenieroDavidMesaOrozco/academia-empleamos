<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperación de Contraseña - Empleamos Temporales</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .corporate-card {
            background: #ffffff;
            width: 100%;
            max-width: 480px;
            padding: 45px 40px;
            border-radius: 16px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.1);
            border: 1px solid #f1f5f9;
        }

        /* LOGO Y MARCA CENTRADOS */
        .corporate-brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 25px;
            text-align: center;
        }

        .corporate-brand img {
            max-width: 130px;
            height: auto;
            margin-bottom: 15px;
        }

        .corporate-logo-text {
            font-size: 22px;
            font-weight: 800;
            color: #1e3a8a;
            letter-spacing: -0.5px;
            margin: 0;
            text-transform: uppercase;
        }

        .corporate-tagline {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: #64748b;
            margin-top: 4px;
            font-weight: 600;
        }

        .corporate-title {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
            text-align: center;
        }

        .corporate-subtitle {
            font-size: 14px;
            color: #475569;
            text-align: center;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .corporate-input-group {
            margin-bottom: 20px;
        }

        .corporate-input-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .corporate-input-group input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.3s ease;
            outline: none;
            background-color: #f8fafc;
        }

        .corporate-input-group input:focus {
            border-color: #2563eb;
            background-color: #ffffff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .corporate-btn {
            width: 100%;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.2s ease, transform 0.1s ease;
            box-shadow: 0 4px 6px rgba(37, 99, 235, 0.2);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .corporate-btn:hover {
            opacity: 0.95;
            transform: translateY(-1px);
        }

        .corporate-alert {
            background-color: #f0fdf4;
            border-left: 4px solid #22c55e;
            color: #166534;
            padding: 12px 16px;
            border-radius: 6px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .corporate-error {
            color: #dc2626;
            font-size: 12px;
            margin-top: 6px;
            display: block;
        }

        .corporate-footer {
            text-align: center;
            margin-top: 25px;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #f1f5f9;
            padding-top: 15px;
        }
    </style>
</head>
<body>

    <div class="corporate-card">
        
        {{-- ENCABEZADO DE IDENTIDAD CORPORATIVA --}}
        <div class="corporate-brand">
            <img src="{{ asset('imagenes/ContenidoCurso/logo-empleamos-job.png') }}" alt="Logo Empleamos">
            <h1 class="corporate-logo-text">Empleamos Temporales</h1>
        </div>

        <h2 class="corporate-title">Recuperación de Acceso</h2>
        <p class="corporate-subtitle">
            Ingresa tu correo electrónico registrado y te enviaremos un enlace seguro para restablecer tus credenciales.
        </p>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="corporate-alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="corporate-input-group">
                <label for="email">Correo Electrónico Corporativo</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="nombre@correo.com" required autofocus>
                @error('email')
                    <small class="corporate-error">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="corporate-btn">Enviar enlace de recuperación</button>
        </form>

        <div class="corporate-footer">
            &copy; {{ date('Y') }} Empleamos Temporales. Todos los derechos reservados.
        </div>
    </div>

</body>
</html>