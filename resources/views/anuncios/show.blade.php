@extends('layouts.master')

@section('titulo', 'Detalle de anuncio')

@section('contenido')
<table class="table table striped table-bordered">
    <tr>
        <td>Imagen</td>
        <td class="text-start">
            <img  alt="" class="rounded" style="max-width: 200px" 
                src="{{$anuncio->imagen?
                    asset('storage/'.config('filesystems.anunciosImageDir')).'/'.$anuncio->imagen: 
                    asset('storage/'.config('filesystems.anunciosImageDir')).'/'.'default.jpg' }}">
        </td>
    </tr>
    <tr>
        <td>Titulo</td>
        <td>{{$anuncio->titulo}}</td>
    </tr>
    <tr>
        <td>Descripcion</td>
        <td>{{$anuncio->descripcion}}</td>
    </tr>
    <tr>
        <td>Precio</td>
        <td>{{$anuncio->precio}}</td>
    </tr>
    <tr>
        <td>Propietario</td>
        <td>{{$anuncio->user ? $anuncio->user->name : 'Sin propietario'}}</td>
    </tr>
    <tr>
        <td>Poblacion</td>
        <td>{{$anuncio->user ? $anuncio->user->poblacion : 'Desconocida'}}</td>
    </tr>
</table>
@auth
<div class="text-end my-3">
    <div class="btn-group mx-2">
        @if(Auth::user()->can('update',$anuncio))
        <a class="mx-2" href="{{route('anuncios.edit', $anuncio->id)}}">
        <img height="40" width="40" src="{{asset('images/buttons/update.png')}}" alt="Modificar" title="Modificar"></a>
        @endif
        @if(Auth::user()->can('delete',$anuncio))
        <a class="mx-2" href="{{route('anuncios.delete', $anuncio->id)}}">
        <img height="40" width="40" src="{{asset('images/buttons/delete.png')}}" alt="Borrar" title="Borrar"></a>
        @endif
    </div>
</div>
@endauth
@endsection

@section('enlaces')
    @parent
        <a href="{{route('anuncios.index')}}" class="btn btn-primary m-2">Listado</a>
@endsection