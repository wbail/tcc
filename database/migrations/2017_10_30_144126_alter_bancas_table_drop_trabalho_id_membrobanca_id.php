<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBancasTableDropTrabalhoIdMembrobancaId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bancas', function (Blueprint $table) {
            $table->integer('academico_trabalho_id')->unsigned()->after('data')->nullable();
            $table->foreign('academico_trabalho_id')->references('id')->on('academico_trabalhos');
            $table->dropColumn('papel');
            $table->dropIndex('bancas_membrobanca_id_foreign');
            $table->dropColumn('membrobanca_id');
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

        });
    }
}
