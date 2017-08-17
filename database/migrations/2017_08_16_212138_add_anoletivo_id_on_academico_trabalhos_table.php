<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAnoletivoIdOnAcademicoTrabalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('academico_trabalhos', function (Blueprint $table) {
            $table->boolean('aprovado')->default(0)->after('id');
            $table->integer('anoletivo_id')->unsigned()->after('aprovado')->nullable();
            $table->foreign('anoletivo_id')->references('id')->on('ano_letivos');
            $table->integer('trabalho_id')->unsigned()->after('anoletivo_id')->nullable();
            $table->foreign('trabalho_id')->references('id')->on('trabalhos');
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
