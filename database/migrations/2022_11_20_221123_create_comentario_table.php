<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComentarioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comentario', function (Blueprint $table) {
            $table->id();
            $table->text('conteudo');
            $table->bigInteger('id_aluno')->unsigned();
            $table->bigInteger('id_usuario_professor')->unsigned();
            $table->timestamps();

            $table->foreign('id_aluno')
                ->references('id')->on('aluno');

            $table->foreign('id_usuario_professor')
                ->references('id')->on('usuario');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comentario');
    }
}
