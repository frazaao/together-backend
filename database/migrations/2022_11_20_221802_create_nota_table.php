<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota', function (Blueprint $table) {
            $table->id();
            $table->decimal('valor');
            $table->bigInteger('id_aluno')->unsigned();
            $table->bigInteger('id_disciplina')->unsigned();
            $table->bigInteger('id_turma')->unsigned();
            $table->enum('trimestre', ['primeiro', 'segundo', 'terceiro', 'quarto']);
            $table->timestamps();

            $table->foreign('id_aluno')
                ->references('id')->on('aluno');

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
        Schema::dropIfExists('nota');
    }
}
