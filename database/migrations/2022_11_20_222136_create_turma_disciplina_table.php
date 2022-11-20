<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurmaDisciplinaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turma_disciplina', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_disciplina')->unsigned();
            $table->bigInteger('id_turma')->unsigned();
            $table->timestamps();

            $table->foreign('id_disciplina')
                ->references('id')->on('disciplina');

            $table->foreign('id_turma')
                ->references('id')->on('turma');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turma_disciplina');
    }
}
