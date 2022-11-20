<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmaDisciplinaUsuarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_disciplina_usuario', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_usuario_professor')->unsigned();
            $table->bigInteger('id_turma_disciplina')->unsigned();
            $table->timestamps();

            $table->foreign('id_usuario_professor')
                ->references('id')->on('usuario');

            $table->foreign('id_turma_disciplina')
                ->references('id')->on('turma_disciplina');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turma_disciplina_usuario');
    }
}
