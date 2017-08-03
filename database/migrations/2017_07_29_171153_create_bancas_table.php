<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bancas', function (Blueprint $table) {
            $table->increments('id');
            $table->char('papel', 1);
            $table->integer('membrobanca_id')->unsigned();
            $table->foreign('membrobanca_id')->references('id')->on('membro_bancas');
            $table->integer('academicotrabalho_id')->unsigned();
            $table->foreign('academicotrabalho_id')->references('id')->on('academico_trabalhos');
            $table->integer('etapaano_id')->unsigned();
            $table->foreign('etapaano_id')->references('id')->on('etapa_anos');
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
        Schema::dropIfExists('bancas');
    }
}
