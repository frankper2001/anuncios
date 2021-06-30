@extends('layouts.master')

@section('titulo', 'Actualización de anuncio')

@section('contenido')
    <form class="my-2 border p-5" method="POST" action="{{route('anuncios.update', $anuncio->id)}}" enctype="multipart/form-data">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="PUT">
        
        <div class="form-group row">
            <label for="inputTitulo" class="col-sm-2 col-form-label">Título</label>
            <input type="text" name="titulo" class="up form-control col-sm-10" id="inputTitulo" placeholder="Titulo" maxlength="50" required="required" value="{{$anuncio->titulo}}">
        </div>
        <div class="form-group row">
            <label for="inputDescripcion" class="col-sm-2 col-form-label">Descripción</label>
            <input type="text" name="descripcion" class="up form-control col-sm-10" id="inputDescripcion" placeholder="Descripcion" maxlength="150" required="required" value="{{$anuncio->descripcion}}">
        </div>
        <div class="form-group row">
            <label for="inputPrecio" class="col-sm-2 col-form-label">Precio</label>
            <input type="number" name="precio" class="up form-control col-sm-10" id="inputPrecio"  min="0" step="0.01" required="required" value="{{$anuncio->precio}}">
        </div>
        <div class="form-group row my-3">
            <div class="col-sm-9">
                <label for="inputImagen" class=" col-form-label">{{$anuncio->imagen? 'Sustituir':'Añadir'}} imagen
                </label>
                <input type="file" name="imagen" class="up form-control-file" id="inputImagen">
                @if($anuncio->imagen)
                <div class="form-check my-3">
                    <input type="checkbox" name="eliminarimagen" class="form-check-input" id="inputEliminar">
                    <label for="inputEliminar" class="form-check-label">Eliminar Imagen</label>
                </div>
                @endif
            </div>
            <div class="col-sm-3">
                <label>Imagen actual:</label>
                <img class="rounded img-thumbnail my-3"
                    alt="Imagen de {{$anuncio->titulo}}"
                    title="Imagen de {{$anuncio->titulo}}"
                    src="{{
                        $anuncio->imagen?
                        asset('storage/'.config('filesystems.anunciosImageDir')).'/'.$anuncio->imagen: 
                        asset('storage/'.config('filesystems.anunciosImageDir')).'/'.'default.jpg' 
                    }}">
            </div>
        </div>
        <div class="form-group row">
            <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
            <button type="reset" class="btn btn-secondary m-2">Reestablecer</button>
        </div>     
    </form>
    <div class="text-end my-3">
        <div class="btn-group mx-2">
            <a class="mx-2" href="{{route('anuncios.edit', $anuncio->id)}}">
            <img height="40" width="40" src="{{asset('images/buttons/update.png')}}" alt="Modificar" title="Modificar"></a>
            <a class="mx-2" href="{{route('anuncios.delete', $anuncio->id)}}">
            <img height="40" width="40" src="{{asset('images/buttons/delete.png')}}" alt="Borrar" title="Borrar"></a>
        </div>
   </div>

   <script>
        inputEliminar.onchange = function(){
            inputImagen.disabled = this.checked;
        }
    </script>

@endsection

@section('enlaces')
    @parent
        <a href="{{route('anuncios.index')}}" class="btn btn-primary m-2">Listado</a>
@endsection
