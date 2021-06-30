@extends('layouts.master')

@section('titulo', 'Nuevo Anuncio')

@section('contenido')
    <form method="POST" action="{{route('anuncios.store')}}" class="my-2 border p-5" enctype="multipart/form-data">
        {{csrf_field()}}
        
        <div class="form-group row">
            <label for="inputTitulo" class="col-sm-2 col-form-label">Título</label>
            <input type="text" name="titulo" class="up form-control col-sm-10" id="inputTitulo" placeholder="Titulo" maxlength="50" required="required" value="{{old('titulo')}}">
        </div>
        <div class="form-group row">
            <label for="inputDescripcion" class="col-sm-2 col-form-label">Descripción</label>
            <input type="text" name="descripcion" class="up form-control col-sm-10" id="inputDescriction" placeholder="Descripcion" maxlength="150" required="required" value="{{old('descripcion')}}">
        </div>
        <div class="form-group row">
            <label for="inputPrecio" class="col-sm-2 col-form-label">Precio</label>
            <input type="number" name="precio" class="up form-control col-sm-10" id="inputPrecio" placeholder="Precio" min="0" step="0.01" required="required" value="{{old('precio')}}">
        </div>
        
        <div class="form-group row">
            <label for="inputImagen" class="col-sm-2 col-form-label">Imagen</label>
            <input type="file" name="imagen" class="up form-control col-sm-10" id="inputImagen">
        </div>
        <div class="form-group row">
            <button type="submit" class="btn btn-success m-2 mt-5">Guardar</button>
            <button type="reset" class="btn btn-secondary m-2">Borrar</button>
        </div>
    </form>

@endsection

@section('enlaces')
    @parent
        <a href="{{route('anuncios.index')}}" class="btn btn-primary m-2">Listado</a>
@endsection

