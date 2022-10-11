@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css" integrity="sha512-494Ejp/5WyoRNfh+nPLhSCQPHhcsbA5PoIGv2/FuEo+QLfW+L7JQGPdh8Qy2ZOmkF27pyYlALrxteMiKau1tyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<h2 class="text-center mb-5">Editar Receta {{$receta->titulo}}</h2>

{{-- {{$receta}} --}}

<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <form method="post" action="{{route('recetas.update', ['receta' => $receta->id])}}" enctype="multipart/form-data" novalidate>
            
            @csrf
            @method('put')
            <div class="form-group">
                <label for="titulo">Titulo Receta</label>

                <input type="text" name="titulo" class="form-control @error('titulo') is-invalid @enderror" id="titulo" placeholder="Titulo Receta" value="{{$receta->titulo}}">

                @error('titulo')
                    <span class="invalidate-feedback d-block" role="alert">
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-2">
                <label for="categoria">Categoria</label>

                <select name="categoria" class="form-control @error('categoria') is-invalid @enderror" id="categoria">
                    <option value="">-- Seleccione --</option>
                    @foreach($categorias as $categoria)
                        <option value="{{$categoria->id}}" {{$receta->categoria_id == $categoria->id ? 'selected' : ''}}>{{$categoria->nombre}}</option>
                    @endforeach
                </select>

                @error('categoria')
                <span invalidate-feedback d-block>
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="preparacion" class="mb-1">Preparacion</label>
                <input name="preparacion" type="hidden" id="preparacion" value="{{$receta->preparacion}}">
                <trix-editor input="preparacion" class="form-control @error('preparacion') is-invalid @enderror"></trix-editor>

                @error('preparacion')
                <span invalidate-feedback d-block>
                    <strong>{{$message}}</strong>
                </span>
                @enderror
            </div>

            <div class="form-group mt-3">
                <label for="ingredientes" class="mb-1">Ingredientes</label>
                <input name="ingredientes" type="hidden" id="ingredientes" value="{{$receta->ingredientes}}">
                <trix-editor input="ingredientes" class="form-control @error('ingredientes') is-invalid @enderror"></trix-editor>

                @error('ingredientes')
                    <span invalidate-feedback d-block>
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group mt-2">
                <label for="imagen">Imagen</label>
                <input id="imagen" class="form-control @error('imagen') is-invalid @enderror" type="file" name="imagen">
                @error('imagen')
                    <span invalidate-feedback d-block>
                        <strong>{{$message}}</strong>
                    </span>
                @enderror
            </div>

            <div class="my-4">
                <p>Imagen Actual:</p>

                <img src="/storage/{{$receta->imagen}}" style="width: 300px">
            </div>

            <div class="form-group mt-2">
                <input type="submit" class="btn btn-primary mr-2 text-white text-uppercase" value="Editar Receta">
                <a href="{{route('recetas.index')}}" class="btn btn-warning text-white text-uppercase">Cancelar</a>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js" integrity="sha512-wEfICgx3CX6pCmTy6go+PmYVKDdi4KHhKKz5Xx/boKOZOtG7+rrm2fP7RUR2o4m/EbPdwbKWnP05dvj4uzoclA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection