<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        //recupera los anuncios del usuario
        $anuncios = $request->user()->anuncios()->paginate(10);
        //carga la vista home pasandole los anuncios
        return view('home', ['anuncios'=>$anuncios]);
    }
}
