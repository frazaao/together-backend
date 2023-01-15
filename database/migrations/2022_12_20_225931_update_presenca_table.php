<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePresencaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('presenca', function (Blueprint $table) {
            $table->bigInteger('created_by')->unsigned()->nullable();

            $table->foreign('created_by')->references('id')->on('usuario')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('presenca', function (Blueprint $table) {
            $table->foreign('created_by')->delete();

            $table->removeColumn('created_by');
        });
    }
}
