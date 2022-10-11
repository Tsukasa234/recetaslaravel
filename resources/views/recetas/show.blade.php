@extends('layouts.app')

@section('content')
    @csrf
    <article class="contenido-receta">
        <h1 class="text-center mb-4">{{$receta->titulo}}</h1>

        <div class="imagen-receta">
            <img src="/storage/{{$receta->imagen}}" class="w-100">
        </div>

        <div class="receta-meta">
            <p>
                <span class="font-weight-bold text-primary">Escrito en: </span>
                {{$receta->categoria->nombre}}
            </p>
            
            <p>
                <span class="font-weight-bold text-primary">Escrito por: </span>
                {{$receta->autor->name}}
            </p>
            
            <p>
                <span class="font-weight-bold text-primary">Creado el: </span>
                @php
                    $fecha = $receta->categoria->updated_at
                @endphp
                <fecha-receta fecha="{{$fecha}}"></fecha-receta>  
            </p>


            <div class="ingrediente">
                <h2 class="my-3 text-primary">Ingredientes:</h2>
                {!! $receta->ingredientes !!}
            </div>
            
            <div class="preparacion">
                <h2 class="my-3 text-primary">Preparacion:</h2>
                {!! $receta->preparacion !!}
            </div>
            {{$like}}
            
            
            <like-button receta-id="{{$receta->id}}" like="{{$like}}"></like-button>

        </div>


    </article>
@endsection