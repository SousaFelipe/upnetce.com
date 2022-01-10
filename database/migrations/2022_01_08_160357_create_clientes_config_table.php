<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientesConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes_config', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');
            $table->integer('tipo_assinante');
            $table->enum('tipo_pessoa', ['F', 'J', 'E'])->default('F');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes_config');
    }
}
