<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableAnunciosAddImageField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('anuncios', function(Blueprint $table){
            //crear el campo imagen en la tabla anuncios
            $table->string('imagen', 255)
                    ->after('precio')
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('anuncios', function(Blueprint $table){
            //eliminar el campo imagen en la tabla anuncios
            $table->dropColumn('imagen');
        });
    }
}
