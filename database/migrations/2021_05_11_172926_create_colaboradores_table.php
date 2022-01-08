<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateColaboradoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');
            $table->bigInteger('setor');

            $table->string('code', 8);
            $table->integer('filial_id', false)->length(11)->unsigned();

            $table->bigInteger('id_ixc')->nullable();
            $table->string('funcionario', 96);
            $table->integer('id_funcao', false)->length(11)->unsigned()->nullable();
            $table->integer('id_departamento', false)->length(11)->unsigned()->nullable();
            $table->enum('ativo', ['S', 'N'])->default('S');
            $table->string('obs', 96)->nullable();
            $table->string('cpf_cnpj', 14)->nullable();
            $table->string('fone_celular', 11)->nullable();
            $table->string('fone_emergencia', 11)->nullable();
            $table->string('email', 96)->nullable();
            $table->double('salario', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('colaboradores');
    }
}
