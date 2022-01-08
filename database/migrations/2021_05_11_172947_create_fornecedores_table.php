<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateFornecedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');

            $table->string('cnpj', 14);
            $table->string('razao', 96);
            $table->string('nome_fantasia', 96);
            $table->date('data_abertura');
            $table->string('contatos', 59);
            $table->string('tipo', 32);

            $table->string('nome', 96);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedores');
    }
}
