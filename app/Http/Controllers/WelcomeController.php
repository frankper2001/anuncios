<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Anuncio;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
}
