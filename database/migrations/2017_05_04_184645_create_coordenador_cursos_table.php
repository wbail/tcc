<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoordenadorCursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordenador_cursos', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('inicio_vigencia');
            $table->dateTime('fim_vigencia')->nullable();
            $table->integer('coordenador_id')->unsigned();
            $table->foreign('coordenador_id')->references('id')->on('membro_bancas');
            $table->integer('curso_id')->unsigned();
            $table->foreign('curso_id')->references('id')->on('cursos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coordenador_cursos');
    }
}
