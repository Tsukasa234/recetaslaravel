@extends('layouts.app')

@section('botones')
    @include('ui.navegacion')
    {{-- <a href="{{route('perfiles.show', ['perfil' => $perfil->id])}}" class="btn btn-secondary">Ver Perfil</a> --}}
@endsection

@section('content')
<h2 class="text-center mb-5">Administra tus recetas</h2>

{{-- {{$recetas}} --}}

<div class="col-md-10 mx-auto bg-white p-3">
    <table class="table">
        <thead class="bg-primary text-light">
            <tr>
                <th scope="col">Titulo</th>
                <th scope="col">Categoria</th>
                <th scope="col">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recetas as $receta)
            <tr>
                <td>{{$receta->titulo}}</td>
                <td>{{$receta->categoria->nombre}}</td>
                <td>
                    <eliminar-receta receta-id="{{$receta->id}}"></eliminar-receta>
                    <a href="{{route('recetas.edit', ['receta' => $receta->id])}}" class="btn btn-dark d-block mb-2 text-white text-uppercase">Editar</a>
                    <a href="{{route('recetas.show', ['receta' => $receta->id])}}" class="btn btn-success d-block text-white text-uppercase">Ver</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="col-12 mt-4 justify-content-center d-flex">
        {{$recetas->links()}}
    </div>
</div>
@endsection