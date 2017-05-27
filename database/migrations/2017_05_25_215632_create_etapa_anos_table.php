<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEtapaAnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('etapa_anos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo', 100);
            $table->dateTime('data_inicial')->nullable();
            $table->dateTime('data_final');
            $table->boolean('ativa')->default(0);
            $table->integer('etapa_id')->unsigned();
            $table->foreign('etapa_id')->references('id')->on('etapas');
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
        Schema::dropIfExists('etapa_anos');
    }
}
