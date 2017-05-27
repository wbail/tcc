<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicosTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academico_trabalhos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('academico_id')->unsigned();
            $table->foreign('academico_id')->references('id')->on('academicos');
            $table->integer('trabalho_id')->unsigned();
            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
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
