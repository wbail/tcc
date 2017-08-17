<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trabalhos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo')->unique();
            $table->boolean('aprovado')->default(0);
            $table->string('ano', 4);
            $table->integer('periodo');
            $table->integer('orientador_id')->unsigned();
            $table->foreign('orientador_id')->references('id')->on('membro_bancas');
            $table->integer('coorientador_id')->unsigned()->nullable();
            $table->foreign('coorientador_id')->references('id')->on('membro_bancas');
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
        Schema::dropIfExists('trabalhos');
    }
}
