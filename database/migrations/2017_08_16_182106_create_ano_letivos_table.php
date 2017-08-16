<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnoLetivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ano_letivos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rotulo', 20);
            $table->boolean('ativo')->default(0);
            $table->dateTime('data');
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
        Schema::dropIfExists('ano_letivos');
    }
}
