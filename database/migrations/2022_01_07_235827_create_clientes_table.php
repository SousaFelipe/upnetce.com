<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');
            $table->bigInteger('user');
            $table->bigInteger('id_ixc');
            $table->string('razao', 125);
            $table->integer('tipo_assinante');
            $table->enum('tipo_pessoa', ['F', 'J', 'E'])->default('F');
            $table->string('cnpj_cpf', 14);
            $table->string('ie_identidade', 30);
            $table->string('rg_orgao_emissor', 20);
            $table->enum('contribuinte_icms', ['S', 'N', 'I'])->enum('N');
            $table->date('data_nascimento');
            $table->enum('ativo', ['S', 'N'])->default('S');
            $table->enum('Sexo', ['M', 'F']);
            $table->date('data_cadastro');
            $table->enum('ativo_serasa', [0, 1, 2])->default(0);
            $table->string('cep', 9);
            $table->string('endereco', 125);
            $table->string('numero', 20)->default('SN');
            $table->string('complemento', 100);
            $table->string('bairro', 100);
            $table->string('cidade', 96);
            $table->string('referencia', 96);
            $table->string('uf', 2);
            $table->enum('tipo_localidade', ['R', 'U'])->default('U');
            $table->string('fone', 20);
            $table->string('telefone_celular', 16);
            $table->string('whatsapp', 16);
            $table->string('email', 125)->unique();
            $table->integer('id_vendedor');
            $table->string('obs', 125);
            $table->string('alerta', 125);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
