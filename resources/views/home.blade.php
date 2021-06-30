@extends('layouts.master')
@section('titulo', 'Perfil de usuario')
@section('contenido')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('You are logged in!') }}</div>
                <div class="card-body">
                    <p>Nombre: {{Auth::user()->name}}</p>
                    <p>E-mail: {{Auth::user()->email}}</p>
                    <p>Teléfono: {{Auth::user()->telefono}}</p>
                    <p>Población: {{Auth::user()->poblacion}}</p>
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif 
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Listado de tareas -->
<div class="row">
        <div class="col-6 text-star">{{ $anuncios->links() }}</div>
        
        <div class="col-6 text-end">
            <p>Nuevo anuncio <a href="{{route('anuncios.create')}}" class="btn btn-success ml-2">+</a></p>
        </div>
        
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
