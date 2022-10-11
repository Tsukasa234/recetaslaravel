<?php

namespace App\Http\Controllers;

use App\Models\Receta;
use Illuminate\Http\Request;
use App\Models\CategoriaReceta;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class RecetaController extends Controller
{
    public function __construct(){
        $this -> middleware('auth', ['except' => 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Auth::user()->recetas->dd();
        // $recetas = auth()->user()->recetas;
        $usuario = auth()->user();

        //Recetas poginadas
        $recetas = Receta::where('user_id', $usuario->id)->paginate(2);

        return view('recetas.index', compact('recetas', 'usuario'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // DB::table('categoria_receta')->get()->pluck('nombre', 'id')->dd();

        //Esta es la manera de obtener las categorias sin modelo
        // $categorias = DB::table('categoria_recetas')->get()->pluck('nombre', 'id');

        //Con modelo
        $categorias = CategoriaReceta::all(['id', 'nombre']);

        return view('recetas.create') -> with('categorias', $categorias);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request['imagen']->store('upload-recetas', 'public'));

        //validacion
        $data = request() -> validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
            'imagen' => 'required|image'
        ]);

        //obtener ruta de la imagen guardada
        $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

        //Resize Image
        $image = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
        $image->save();

        //ingresar los datos en la bd(sin modelo)
        // DB::table('recetas') -> insert([
        //     'titulo' => $data['titulo'],
        //     'ingredientes' => $data['ingredientes'],
        //     'preparacion' => $data['preparacion'],
        //     'imagen' => $ruta_imagen,
        //     'user_id' => Auth::user()->id,
        //     'categoria_id' => $data['categoria'],
        // ]);

        //Ingresar los datos con Modelo
        auth()->user()->recetas()->create([
            'titulo' => $data['titulo'],
            'preparacion' => $data['preparacion'],
            'ingredientes' => $data['ingredientes'],
            'imagen' => $ruta_imagen,
            'categoria_id' => $data['categoria'],
        ]);

        // dd($request->all());
        //Redireccionar

        return redirect()->action([RecetaController::class, 'index']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function show(Receta $receta)
    {
        $like = (auth()->user()) ? auth()->user()->likesMe->contains($receta->id) : false;

        return view('recetas.show', compact('receta', 'like'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function edit(Receta $receta)
    {
        $this->authorize('view', $receta);

        $categorias = CategoriaReceta::all(['id', 'nombre']);
        return view('recetas.edit', compact('categorias', 'receta'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Receta $receta)
    {
        $this->authorize('update', $receta);

        $data = request() -> validate([
            'titulo' => 'required|min:6',
            'categoria' => 'required',
            'preparacion' => 'required',
            'ingredientes' => 'required',
        ]);

        $receta->titulo = $data['titulo'];
        $receta->categoria_id = $data['categoria'];
        $receta->preparacion = $data['preparacion'];
        $receta->ingredientes = $data['ingredientes'];

        if (request('imagen')) 
        {
            $ruta_imagen = $request['imagen']->store('upload-recetas', 'public');

            //Resize Image
            $image = Image::make(public_path("storage/{$ruta_imagen}"))->fit(1000, 550);
            $image->save();;

            $receta->imagen = $ruta_imagen;
        }

        $receta -> save();

        return redirect()->action([RecetaController::class, 'index']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Receta  $receta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Receta $receta)
    {
        $this->authorize('delete', $receta);

        $receta->delete();

        return redirect()->action([RecetaController::class, 'index']);
    }
}
