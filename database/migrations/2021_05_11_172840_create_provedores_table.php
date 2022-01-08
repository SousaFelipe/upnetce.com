<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateProvedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('provedores', function (Blueprint $table) {
            $table->id();

            $table->string('cnpj', 14);
            $table->string('razao', 96);
            $table->string('nome_fantasia', 96);
            $table->date('data_abertura');
            $table->string('porte', 32);
            $table->string('contatos', 59);
            $table->string('tipo', 32);
            $table->string('situacao', 32);
            $table->date('data_situacao', 32);

            $table->string('logradouro', 32);
            $table->string('bairro', 32);
            $table->string('cep', 8);
            $table->string('municipio', 32);
            $table->string('uf', 32);

            $table->string('titular', 96);
            $table->string('titular_contato', 11);
            $table->string('class_responsavel', 96);

            $table->enum('ativo', ['S', 'N']);

            $table->string('ixc_token', 66);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('provedores');
    }
}
