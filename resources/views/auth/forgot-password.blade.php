@extends('layouts.guest')

@section('head')
    <link href="{{ asset('css/forgot-password.css') }}" rel="stylesheet">
@endsection

@section('content')
<div class="forgot-wrapper">
    <div class="card">
        <h1 class="title">Recupera tu contraseña</h1>
        <p class="subtitle">
            Ingresa tu correo y te enviaremos un enlace para que restablezcas tu contraseña.
        </p>

        {{-- Session Status --}}
        @if (session('status'))
            <div class="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                @error('email')
                    <small class="error">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn">Enviar enlace</button>
        </form>
    </div>
</div>
@endsection
