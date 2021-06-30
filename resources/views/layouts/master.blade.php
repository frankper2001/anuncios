<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ejemplo CRUD con Laravel - Anuncios">
    <title>{{config('app.name')}} - @yield('titulo')</title>
    <!-- CSS para Bootstrap -->
    <link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <script src="{{asset('js/app.js')}}" defer></script>
     <!-- Styles -->
     <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body class="container p-3">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <a class="dropdown-item" href="/home">Home</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                    
                @endguest
            </ul>
        </div>
    </nav>
    <!-- PARTE SUPERIOR -->
    @section('navegacion')
    @php($pagina=Route::currentRouteName())
    <nav>
        <ul class="nav nav-pills my-3">
            <li class="nav-item mr-2">
                <a class="nav-link {{$pagina=='portada'? 'active':''}}" href="{{url('/')}}">Inicio</a>
            </li>
            <li class="nav-item mr-2">
                <a class="nav-link {{$pagina=='anuncios.index' || $pagina=='anuncios.search'? 'active':''}}" href="{{route('anuncios.index')}}">Anuncios</a>
            </li>
            @auth
            <li class="nav-item">
                <a class="nav-link {{$pagina=='home'? 'active':''}}" href="{{route('home')}}">Mis Anuncios</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{$pagina=='anuncios.create'? 'active':''}}" href="{{route('anuncios.create')}}">Nuevo Anuncio</a>
            </li>
            @endauth
        </ul>
    </nav>
    @show
    <!-- PARTE CENTRAL -->
    <main>
        <h2>@yield('titulo')</h2>
        
        @includeWhen(Session::has('success'), 'layouts.success')
        @includeWhen($errors->any(), 'layouts.error')


        @yield('contenido')

        <div class="btn-group" role="group" aria-label="Links">
            @section('enlaces')
                <a href="{{ url()->previous()}}" class="btn btn-primary m-2">Atras</a>
                <a href="{{ route('portada') }}" class="btn btn-primary m-2">Inicio</a>         
            @show       
        </div>
    </main>
    <!-- PARTE INFERIOR -->
    @section('pie')
    <footer class="page-footer font-small p-4 bg-light">
        <p>Aplicación creada por Desarrollo-Web {{$autor}} haciendo uso de <b>Laravel</b> y <b>Bootstrap.</b></p>
    </footer>
    @show
    
</body>
</html>