<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespesasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despesas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_ixc')->nullable();

            $table->bigInteger('provedor');
            $table->bigInteger('user');
            $table->bigInteger('categoria');
            $table->bigInteger('despesa')->nullable();
            $table->bigInteger('orcamento')->nullable();

            $table->string('codigo_barras', 32)->nullable();
            $table->date('data_cancelamento')->nullable();
            $table->double('valor_aberto', 8, 2)->nullable();
            $table->double('valor_cancelado', 8, 2)->nullable();
            $table->double('valor_pago', 8, 2)->nullable();
            $table->double('valor_total_pago', 8, 2)->nullable();
            $table->enum('tipo_pagamento', [])->default('D');


            $table->double('valor', 8, 2);
            $table->enum('status', ['A', 'R', 'C'])->default('A');
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
        Schema::dropIfExists('despesas');
    }
}
