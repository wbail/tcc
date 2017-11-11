<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembroBancasBancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membro_bancas_bancas', function (Blueprint $table) {
            $table->increments('id');
            $table->char('papel', 1);
            $table->integer('membro_banca_id')->unsigned();
            $table->foreign('membro_banca_id')->references('id')->on('membro_bancas');
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
        Schema::dropIfExists('membro_bancas_bancas');
    }
}
