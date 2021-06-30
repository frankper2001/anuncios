@extends('layouts.master')

@section('titulo', "Confirmación de borrado del anuncio: $anuncio->titulo")

@section('contenido')
    <form class="my-2 border p-3" method="POST" action="{{URL::temporarySignedRoute('anuncios.destroy', now()->addMinutes(5), $anuncio->id )}}">
        {{csrf_field()}}
        <input type="hidden" name="_method" value="DELETE">
        <figure>
            <figcaption>Imagen actual:</figcaption>
            <img  alt="" class="rounded" style="max-width: 400px" 
                src="{{$anuncio->imagen?
                    asset('storage/'.config('filesystems.anunciosImageDir')).'/'.$anuncio->imagen: 
                    asset('storage/'.config('filesystems.anunciosImageDir')).'/'.'default.jpg' }}">
        </figure>
        <label for="confirmdelete">Confirmar el borrado del anuncio: {{"$anuncio->titulo"}}</label>
        <input type="submit" alt="Borrar" title="Borrar" class="btn btn-danger m-4" value="Borrar" id="confirmdelete">
    </form>
@endsection

@section('enlaces')
    @parent
    <a href="{{route('anuncios.index')}}" class="btn btn-primary m-2">Listado</a>
    <a href="{{route('anuncios.show', $anuncio->id)}}" class="btn btn-primary m-2">Regresar a detalles de anuncio</a>
@endsection