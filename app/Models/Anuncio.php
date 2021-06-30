<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    use HasFactory;
    // campos en BDD donde se permite asignacion masiva
    protected $fillable = ['titulo','descripcion','precio', 'imagen', 'user_id'];
     
    //retorna el usuario propietario del anuncio
    public function user(){
      return $this->belongsTo('\App\Models\User');
    }
}

