@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Roles de {{ $user->name }}</h2>

    <form action="{{ route('usuarios.roles.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            @foreach($roles as $rol)
                <div class="col-md-4 mb-2">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox"
                               name="roles[]" value="{{ $rol->id }}"
                               {{ $user->roles->contains($rol) ? 'checked' : '' }}>
                        <label class="form-check-label">{{ $rol->name }}</label>
                    </div>
                </div>
            @endforeach
        </div>

        <button class="btn btn-primary mt-3">Actualizar Roles</button>
    </form>
</div>
@endsection
