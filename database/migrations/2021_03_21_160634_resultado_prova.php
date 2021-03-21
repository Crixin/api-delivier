<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ResultadoProva extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resultado_prova', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('corredor_id');
            $table->integer('prova_id');
            $table->time('hora_inicio');
            $table->time('hora_fim');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resultado_prova');
    }
}
