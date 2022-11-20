<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerfilRegraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_regra', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_perfil')->unsigned();
            $table->bigInteger('id_regra')->unsigned();
            $table->timestamps();

            $table->foreign('id_perfil')->references('id')->on('perfil');
            $table->foreign('id_regra')->references('id')->on('regra');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_regra');
    }
}
