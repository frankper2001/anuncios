<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//autenticación
Auth::routes(['verify'=>false]);

/* Route::get('/', function () {
    return view('welcome');
}); */

//PORTADA
Route::get('/', [WelcomeController::class, 'index'])->name('portada');

// CRUD de anuncios
Route::resource('anuncios',AnuncioController::class);

// Formulario de confirmacion de eliminacion
Route::get('anuncios/delete/{anuncio}',[AnuncioController::class, 'delete'])->name('anuncios.delete');

/* Route::delete('anuncio/{id}',[AnuncioController::class, 'destroy']); */

/* 
// descarga de ficheros
Route::get('image', function (Request $request){
    return response()->download('images/tasks/portada.png', 'miportada.png');
});
// descarga de fichero no en public
Route::get('readme/download', function (){
    return response()->download(base_path('readme.md'), 'ficherito');
});
// apertura del fichero em el navegador
Route::get('download/image', function (Request $request){
    return response()->file(base_path('public\images\tasks\portada.png'), ['content-type'=>'image/png']);
});
*/

Auth::routes(['verify'=>true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::fallback(function(){
    return redirect()->route('portada');
});

