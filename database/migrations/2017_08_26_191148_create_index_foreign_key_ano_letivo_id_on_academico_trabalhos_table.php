<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndexForeignKeyAnoLetivoIdOnAcademicoTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academico_trabalhos', function (Blueprint $table) {
            $table->integer('ano_letivo_id')->unsigned()->after('aprovado')->nullable();
            $table->foreign('ano_letivo_id')->references('id')->on('ano_letivos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('academico_trabalhos', function (Blueprint $table) {
            //
        });
    }
}
