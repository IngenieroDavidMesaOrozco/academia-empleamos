@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
    <div class="row row-cols-1 row-cols-md-4 g-3">
             @can('usuarios.view')

        <div class="col item-container text-center">

            <a href="{{route('usuarios.index')}}">
                <img src="{{ asset('imagenes/usuarios.png') }}" alt="Imagen 1" class="img-link" width="75%" height="75%">
            </a>
        <p class="mt-2 fw-bold">USUARIOS</p>

        </div>
             @endcan


       

           @can('parametros.view')

           <div class="col item-container text-center">

            <a href="{{route('areas.index')}}">
                <img src="{{ asset('imagenes/usuarios.png') }}" alt="Imagen 1" class="img-link" width="75%" height="75%">
            </a>
        <p class="mt-2 fw-bold">USUARIOS</p>

        </div>
        <div class="col item-container text-center">
            <a href="{{route('parametros.edit')}}">
                <img src="{{ asset('imagenes/parametros.png') }}" alt="Imagen 1" class="img-link" width="75%" height="75%">
            </a>
                    <p class="mt-2 fw-bold">PARAMETROS</p>

        </div>
             @endcan

             @can('roles.view')

        <div class="col item-container text-center">
            <a href="{{route('roles.index')}}">
                <img src="{{ asset('imagenes/Seguridad.png') }}" alt="Imagen 1" class="img-link" width="75%" height="75%">
            </a>
                    <p class="mt-2 fw-bold">SEGURIDAD</p>

        </div>
             @endcan

             @can('unificado.view')

          <!--<div class="col item-container">
            <a href="/pagina8">
                <img src="{{ asset('imagenes/imagen8.jpg') }}" alt="Imagen 8" class="img-link">
            </a>
        </div>-->
             @endcan

    </div>
@endsection
