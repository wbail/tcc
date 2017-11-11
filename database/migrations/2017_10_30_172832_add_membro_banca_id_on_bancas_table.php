<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMembroBancaIdOnBancasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bancas', function (Blueprint $table) {
            $table->integer('membrobanca_id')->unsigned()->after('data')->nullable();
            $table->foreign('membrobanca_id')->references('id')->on('membro_bancas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bancas', function (Blueprint $table) {
            //
        });
    }
}
