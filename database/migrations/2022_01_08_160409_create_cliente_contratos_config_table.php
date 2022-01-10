<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteContratosConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_contratos_config', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');
            
            $table->enum('tipo', ['I', 'T', 'S', 'SVA'])->nullable();
            $table->integer('id_tipo_contrato')->nullable();
            $table->integer('id_modelo')->nullable();
            $table->integer('id_filial')->nullable();
            $table->enum('status', ['P', 'A', 'I', 'N', 'D'])->nullable();
            $table->integer('id_tipo_documento')->nullable();
            $table->integer('id_carteira_cobranca')->nullable();
            $table->integer('id_vendedor')->nullable();
            $table->enum('cc_previsao', ['P', 'N', 'S', 'M'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_contratos_config');
    }
}
