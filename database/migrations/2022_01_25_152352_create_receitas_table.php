<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReceitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('receitas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ixc')->nullable();

            $table->bigInteger('provedor');
            $table->bigInteger('user');
            $table->bigInteger('categoria');
            $table->bigInteger('receita')->nullable();

            $table->double('valor', 8, 2);
            $table->enum('status', ['A', 'R', 'C'])->default('A');
            $table->dateTime('data_abertura');
            $table->dateTime('data_agendamento')->nullable();
            $table->dateTime('data_baixa')->nullable();
            $table->enum('parcelada', ['S', 'N'])->default('N');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('receitas');
    }
}
