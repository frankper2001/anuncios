<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\AnuncioStoreRequest;
use App\Http\Requests\AnuncioUpdateRequest;

class AnuncioController extends Controller
{   
    // constructor
    public function __construct(){
        //pone un middleware solo a destroy
        //$this->middleware('throttle:3,1')->only('destroy');
        $this->middleware('verified')->except('index', 'show','search');

        // falta search ************************************


    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $anuncios = Anuncio::orderBy('id', 'DESC')->paginate(20);

        return view('anuncios.list', ['anuncios'=>$anuncios]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // mostrar formulario
        return view('anuncios.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AnuncioStoreRequest $request)
    {
        //validar datos de entrada con validator
       // $request->validate([
            // la validacion ahora esta en app/Html/Request/TaskStoreRequest LAR17->72
       // ]);

         //recuperar datos del formulario excepto la imagen
         $datos = $request->only(['titulo','descripcion','precio']);
         //el valor por defecto para la imagen sera null
         $datos += ['imagen' =>NULL];
         //recuperacion de la imagen
         if($request->hasFile('imagen')){
             //sube la imagen al directorio indicado en el fichero de config
             $ruta = $request->file('imagen')->store(config('filesystems.anunciosImageDir'));
 
             //nos quedamos solo con el nombre del fichero para añadirlo a la BDD
             $datos['imagen'] = pathinfo($ruta, PATHINFO_BASENAME);
         }
          // recuperacion del id del usuario
        $datos += ['user_id' => $request->user()->id];
        //creacion y guardado del nuevo anuncio con los datos
        $anuncio = Anuncio::create($datos);

        //crear y guardar nuevo anuncio con datos POST
        //$anuncio = Anuncio::create($request->all());

        //redirección a lista de anuncios
        /* return redirect()->route('anuncios.index')->with('success', "anuncio $anuncio->titulo añadido correctamente"); */
        return redirect()->route('anuncios.show', $anuncio->id)
                        ->with('success', "Anuncio  $anuncio->titulo añadido correctamente")
                        ->cookie('lastInsertID', $anuncio->id, 0); // adjuntamos una cookie
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Anuncio $anuncio)
    {
        //carga vista y pasa el anuncio
        return view('anuncios.show', ['anuncio'=>$anuncio]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Anuncio $anuncio)
    {
        if($request->user()->cant('edit',$anuncio))
        abort(401, 'No puedes eliminar este anuncio, no eres el propietario');

        //carga vista y con formulario para modificar  el anuncio
        return view('anuncios.update')->with('anuncio',$anuncio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Anuncio $anuncio)
    {
        //
        if($request->user()->cant('update',$anuncio))
        abort(401, 'No puedes eliminar este anuncio, no eres el propietario');
        //validar datos con validator
        $request->validate([
             // la validacion ahora esta en app/Html/Request/TaskUpdateRequest LAR17->72
        ]);
        //toma datos del formulario 
        $datos = $request->only(['titulo','descripcion','precio']);

        if($request->hasFile('imagen')){
            //marcamos la imagen antigua para ser borrada si el update va bien
            if($anuncio->imagen)
                $aBorrar = config('filesystems.anunciosImageDir').'/'.$anuncio->imagen;
                
                //sube la imagen al directorio indicado en el fichero de config
                $ruta = $request->file('imagen')->store(config('filesystems.anunciosImageDir'));

                //nos quedamos solo con el nombre del fichero para añadirlo a la BDD
                $datos['imagen'] = pathinfo($ruta, PATHINFO_BASENAME);
        }
        //en caso de que nos pidan eliminar la imagen
        if($request->filled('eliminarimagen') && $anuncio->imagen){
            $datos['imagen'] = NULL;
            $aBorrar = config('filesystems.anunciosImageDir').'/'.$anuncio->imagen;
        }

        //al actualizar debemos tener en cuenta varias cosas:
        if($anuncio->update($datos)){ //si todo va bien
            if(isset($aBorrar))
                Storage::delete($aBorrar); //borramos foto antigua
        }else{ // si algo falla
            if(isset($imagenNueva))
                Storage::delete($imagenNueva); //borramos la foto nueva
        }

         //sin cookie
         return back()->with('success', "Anuncio $anuncio->titulo actualizado");
    }

    public function delete(Request $request, Anuncio $anuncio)
    {
        if($request->user()->cant('delete',$anuncio))
        abort(401, 'No puedes eliminar este anuncio, no eres el propietario');

        // muestra vista de confirmacion de eliminacion
        return view('anuncios.delete',['anuncio'=>$anuncio]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Anuncio $anuncio)
    {
        if($request->user()->cant('destroy',$anuncio))
        abort(401, 'No puedes eliminar este anuncio, no eres el propietario');
       /*  if(!$request->hasValidSignature())
            abort (401, 'La firma de la URL no se ha podido validar');
        //busca el task seleccionado
        //$task = Task::findOrFail($id);
        //lo borra de la BDD
        $task->delete(); */

        //si se consigue eliminar la task y tiene foto...
        if($anuncio->delete() && $anuncio->imagen)
            //elimina el fichero
            Storage::delete(config('filesystems.anunciosImageDir').'/'.$anuncio->imagen);

        //redirige a la lista de anuncios
        return redirect('anuncios')->with('success', "Anuncio $anuncio->titulo eliminado");
    }

    // pendiente search
    public function search(Request $request){
        $request->validate([
            'titulo' => 'max:16'
        ]);
        
        $titulo = $request->input('titulo','');

        //realiza la consulta
        $anuncios = Anuncio::where('titulo','like',"%$titulo%")
                        ->paginate(10)
                        ->appends(['titulo'=>$titulo]);
        return view('anuncios.list', ['anuncios'=>$anuncios, 'titulo'=>$titulo]);
    }
}
