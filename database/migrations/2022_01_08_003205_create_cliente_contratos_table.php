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
        Schema::create('cliente_contratos', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('provedor');
            $table->bigInteger('user');
            $table->bigInteger('id_ixc');
            $table->string('cliente');

            $table->integer('id_cliente'); // Id IXC do cliente
            $table->enum('tipo', ['I', 'T', 'S', 'SVA'])->default('I'); // Internet | Telefonia | Serviços | SVA
            $table->integer('id_vd_contrato'); // Id IXC do plano de venda
            $table->string('contrato', 100); // Título IXC do plano
            $table->integer('id_tipo_contrato'); // Id IXC do tipo de vencimento
            $table->integer('id_vendedor'); // Id IXC do vendedor
            $table->integer('tipo_cobranca', ['P', 'I', 'E']); //
            
            $table->date('data'); // 
            $table->string('cep', 9); //
            $table->string('endereco', 125); //
            $table->string('numero', 20)->default('SN'); //
            $table->string('complemento', 100); //
            $table->string('bairro', 100); //
            $table->string('cidade', 96); //
            $table->string('referencia', 96); //

            $table->integer('id_modelo'); // Modelo de impressão do contrato
            $table->integer('id_filial'); // Id IXC da filial
            $table->enum('status', ['P', 'A', 'I', 'N', 'D']); //
            $table->enum('status_internet', ['A', 'D', 'CM', 'CA', 'FA', 'AA']); //
            $table->integer('id_tipo_documento'); // Tipo de documento Fatura - Ex: 500 -> Serviços Prestados
            $table->integer('id_carteira_cobranca'); // Ex: Conta Interna
            $table->enum('cc_previsao', ['P', 'N', 'S', 'M']); //
            $table->enum('renovacao_automatica', ['S', 'N'])->default('N'); //
            $table->enum('bloqueio_automatico', ['S', 'N'])->default('N'); //
            $table->enum('aviso_atraso', ['S', 'N'])->default('S'); //
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_contratos');
    }
}
