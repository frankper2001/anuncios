@extends('layouts.master')

@section('titulo', 'Listado de anuncios')

@section('contenido')
    <form method="POST" action="{{route('anuncios.search')}}" class="d-flex flex-row mb-2">
        {{csrf_field()}}
        <input name="titulo" type="text" class="form-control form-control-sm" placeholder="Buscar por titulo" maxlength="16"  value="{{empty($titulo)? '': $titulo}}">
        <button type="submit" class="col btn btn-primary m-2">Buscar</button>
    </form>
    <div class="row">
        <div class="col-6 text-star">{{ $anuncios->links() }}</div>
        @auth
        <div class="col-6 text-end">
            <p>Nuevo anuncio<a href="{{route('anuncios.create')}}" class="btn btn-success ml-2">+</a></p>
        </div>
        @endauth
    </div>

    <table class="table table-striped table-bordered">
        <tr>
            <th>Imagen</th>
            <th>Titulo</th>
            <th>Descripcion</th>
            <th>Precio</th>
            <th>Operaciones</th>
        </tr>
        @foreach($anuncios as $anuncio)
        <tr>
            <td class="text-center" style="max-width: 80px">
                <img style="max-width: 90%" alt="" class="rounded"
                    src="{{$anuncio->imagen? 
                        asset('storage/'.config('filesystems.anunciosImageDir')).'/'.$anuncio->imagen: 
                        asset('storage/'.config('filesystems.anunciosImageDir')).'/'.'default.jpg' }}">
            </td> 
            <td>{{$anuncio->titulo}}</td>
            <td>{{$anuncio->descripcion}}</td>
            <td>{{$anuncio->precio}}</td>
            <td class="text-center">
                <a href="{{route('anuncios.show', $anuncio->id)}}">
                <img height="20" width="20" src="{{asset('images/buttons/show.png')}}" alt="Ver detalles" title="Ver detalles"></a>
                @auth
                @if(Auth::user()->can('update',$anuncio))
                <a href="{{route('anuncios.edit', $anuncio->id)}}">
                <img height="20" width="20" src="{{asset('images/buttons/update.png')}}" alt="Modificar" title="Modificar"></a>
                @endif
                @if(Auth::user()->can('delete',$anuncio))
                <a href="{{route('anuncios.delete', $anuncio->id)}}">
                <img height="20" width="20" src="{{asset('images/buttons/delete.png')}}" alt="Borrar" title="Borrar"></a>
                @endif
                @endauth
            </td>
        </tr>
        @endforeach
        
    </table>
    
@endsection

@section('enlaces')
   @parent
@endsection    