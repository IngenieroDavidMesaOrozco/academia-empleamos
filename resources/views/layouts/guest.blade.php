{{-- resources/views/layouts/guest.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Invitado')</title>

    {{-- Estilos principales --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Estilos específicos por vista --}}
    @yield('head')

    <style>
        body {
            background: linear-gradient(to right, #667eea, #764ba2);
            background-size: cover;
            background-attachment: fixed;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .guest-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .card-container {
            background-color: #ffffff;
            padding: 2.5rem;
            max-width: 480px;
            width: 100%;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .app-name {
            font-size: 1.75rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }
    </style>
</head>
<body>

    <div class="guest-container">
        <div class="card-container">
            <div class="app-name">{{ config('app.name') }}</div>
            @yield('content')
        </div>
    </div>

</body>
</html>
