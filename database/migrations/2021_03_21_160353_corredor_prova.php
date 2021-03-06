<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CorredorProva extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('corredor_prova', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('corredor_id')->constrained('corredor');
            $table->foreignId('prova_id')->constrained('prova');
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
        Schema::dropIfExists('corredor_prova');
    }
}
