@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cambio obligatorio de contraseña</h2>
  {{-- Mostrar errores --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mostrar mensaje de éxito (opcional) --}}
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.forzar.cambio') }}">
        @csrf

        <div class="form-group">
            <label>Nueva contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        <div class="form-group mt-2">
            <label>Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Actualizar contraseña</button>
    </form>
</div>
@endsection
