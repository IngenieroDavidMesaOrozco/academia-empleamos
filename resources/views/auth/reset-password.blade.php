{{-- resources/views/auth/reset-password.blade.php --}}

@extends('layouts.guest')

@section('title', 'Restablecer contraseña')

@section('head')
    <link rel="stylesheet" href="{{ asset('css/forgot-password.css') }}">
@endsection

@section('content')
    <div class="title">Restablecer contraseña</div>
    <p class="subtitle">
        Estás a un paso de recuperar el acceso. Ingresa tu nueva contraseña y confírmala.
    </p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        {{-- Token oculto --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div class="input-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required autofocus>
            @error('email')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        {{-- Contraseña --}}
        <div class="input-group">
            <label for="password">Nueva Contraseña</label>
            <input type="password" id="password" name="password" required>
            @error('password')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        {{-- Confirmación --}}
        <div class="input-group">
            <label for="password_confirmation">Confirmar Contraseña</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
            @error('password_confirmation')
                <small class="error">{{ $message }}</small>
            @enderror
        </div>

        <div class="form-footer">
            <button type="submit" class="btn">Restablecer contraseña</button>
        </div>
    </form>
@endsection
