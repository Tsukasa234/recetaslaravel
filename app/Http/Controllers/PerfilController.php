<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use App\Models\Receta;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct(){
        $this -> middleware('auth', ['except' => 'show']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function show(Perfil $perfil)
    {
        //Obtener las recetas con paginacion
        $recetas = Receta::where('user_id', $perfil->id)->paginate(6);
        return view('perfiles.show', compact('perfil', 'recetas'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function edit(Perfil $perfil)
    {
        $this->authorize('view', $perfil);
        return view('perfiles.edit', compact('perfil'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Perfil  $perfil
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Perfil $perfil)
    {
        //validacion
        $this->authorize('update', $perfil);

        $data = request() -> validate([
            'nombre' => 'required',
            'url' => 'required',
            'biografia' => 'required',
        ]);

        //Validacion Imagen
        if (request('imagen')) 
        {
            $ruta_imagen = $request['imagen']->store('upload-perfil', 'public');

            //Resize Image
            $image = Image::make(public_path("storage/{$ruta_imagen}"))->fit(600, 600);
            $image->save();

            $arreglo_imagen = [ 'imagen' => $ruta_imagen];

        }
        //Asignar nombre y URL
        auth()->user()->url = $data['url'];
        auth()->user()->name = $data['nombre'];
        auth()->user()->save();
        //Eliminar Campo url y name de $data
        unset($data['url']);
        unset($data['nombre']);
        //Asignar biografia e imagen
        auth()->user()->perfil()->update(array_merge(
            $data,
            $arreglo_imagen ?? []
        )
        );
        //Guardar Informacion
        
        //Redireccionar
        return redirect()->action([RecetaController::class, 'index']);
    }
}
