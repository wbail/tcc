<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtapaTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapa_trabalhos', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('excecao')->default(0);
            $table->integer('etapaano_id')->unsigned();
            $table->foreign('etapaano_id')->references('id')->on('etapa_anos');
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
        Schema::dropIfExists('etapa_trabalhos');
    }
}
