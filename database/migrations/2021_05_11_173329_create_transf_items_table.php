<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transf_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');

            $table->bigInteger('produto');
            $table->bigInteger('alm_entrada');
            $table->bigInteger('alm_saida');
            $table->integer('quantidade', false)->length(11)->unsigned();
            $table->date('data');
            $table->time('hora');
            $table->string('termo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transf_items');
    }
}
