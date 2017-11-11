<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAcademicoBancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('academico_bancas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('academico_id')->unsigned();
            $table->foreign('academico_id')->references('id')->on('academicos');
            $table->integer('banca_id')->unsigned();
            $table->foreign('banca_id')->references('id')->on('bancas');
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
        Schema::dropIfExists('academico_bancas');
    }
}
