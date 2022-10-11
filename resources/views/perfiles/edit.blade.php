@extends('layouts.app')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.css" integrity="sha512-494Ejp/5WyoRNfh+nPLhSCQPHhcsbA5PoIGv2/FuEo+QLfW+L7JQGPdh8Qy2ZOmkF27pyYlALrxteMiKau1tyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('botones')
    <a href="{{route('recetas.index')}}" class="btn btn-primary mr-2 text-white">Volver</a>
@endsection

@section('content')
    <h1 class="text-center">Editar mi perfil</h1>

    <div class="row justify-content-center mt-5">
        <div class="col-md-10 bg-white p-3">
            <form action="{{route('perfiles.update',['perfil' => $perfil->id])}}" method="post" enctype="multipart/form-data" novalidate>
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="nombre">Nombre</label>

                    <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror" id="nombre" placeholder="Tu Nombre" value="{{$perfil->usuario->name}}">

                    @error('nombre')
                        <span class="invalidate-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group mt-3">
                    <label for="url">Sitio Web</label>
    
                    <input type="text" name="url" class="form-control @error('url') is-invalid @enderror" id="url" placeholder="Tu Sitio Web" value="{{$perfil->usuario->url}}">
    
                    @error('url')
                        <span class="invalidate-feedback d-block" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
    
                <div class="form-group mt-3">
                    <label for="biografia" class="mb-1">Biografia</label>
                    <input name="biografia" type="hidden" id="biografia" value="{{$perfil->biografia}}">
                    <trix-editor input="biografia" class="form-control @error('biografia') is-invalid @enderror"></trix-editor>
    
                    @error('biografia')
                        <span invalidate-feedback d-block>
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
    
                <div class="form-group mt-2">
                    <label for="imagen">Tu Imagen</label>
                    <input id="imagen" class="form-control @error('imagen') is-invalid @enderror" type="file" name="imagen">
                    @error('imagen')
                        <span invalidate-feedback d-block>
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                </div>
    
                @if($perfil->imagen)
                    <div class="my-4">
                        <p>Imagen Actual:</p>
    
                        <img src="/storage/{{$perfil->imagen}}" style="width: 300px">
                    </div>
                @endif
    
                <div class="form-group mt-2">
                    <input type="submit" class="btn btn-primary text-white text-uppercase" value="Actualizar">
                    <a href="{{route('perfiles.show', ['perfil' => auth()->user()->id])}}" class="btn btn-warning mr-2 text-white text-uppercase">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.2.1/trix.js" integrity="sha512-wEfICgx3CX6pCmTy6go+PmYVKDdi4KHhKKz5Xx/boKOZOtG7+rrm2fP7RUR2o4m/EbPdwbKWnP05dvj4uzoclA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endsection