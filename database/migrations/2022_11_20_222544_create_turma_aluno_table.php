<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmaAlunoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_aluno', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_turma')->unsigned();
            $table->bigInteger('id_aluno')->unsigned();
            $table->timestamps();

            $table->foreign('id_turma')
                ->references('id')->on('turma');

            $table->foreign('id_aluno')
                ->references('id')->on('aluno');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turma_aluno');
    }
}
