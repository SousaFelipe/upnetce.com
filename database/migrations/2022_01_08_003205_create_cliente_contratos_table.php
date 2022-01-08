<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateClienteContratosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientecontratos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');
            $table->bigInteger('user');
            $table->bigInteger('id_ixc');
            $table->enum('tipo', ['I', 'T', 'S', 'SVA'])->default('I');
            $table->integer('id_cliente');
            $table->string('cliente');
            $table->integer('id_vd_contrato');
            $table->string('contrato', 100);
            $table->integer('id_tipo_contrato');
            $table->integer('id_modelo');
            $table->integer('id_filial');
            $table->date('data');
            $table->enum('status', ['P', 'A', 'I', 'N', 'D']);
            $table->enum('status_internet', ['A', 'D', 'CM', 'CA', 'FA', 'AA']);
            $table->integer('id_tipo_documento');
            $table->integer('id_carteira_cobranca');
            $table->integer('id_vendedor');
            $table->enum('cc_previsao', ['P', 'N', 'S', 'M']);
            $table->enum('tipo_cobranca', ['P', 'I', 'E']);
            $table->enum('renovacao_automatica', ['S', 'N'])->default('N');
            $table->enum('bloqueio_automatico', ['S', 'N'])->default('N');
            $table->enum('aviso_atraso', ['S', 'N'])->default('S');
            $table->string('cep', 9);
            $table->string('endereco', 125);
            $table->string('numero', 20)->default('SN');
            $table->string('complemento', 100);
            $table->string('bairro', 100);
            $table->string('cidade', 96);
            $table->string('referencia', 96);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientecontratos');
    }
}
