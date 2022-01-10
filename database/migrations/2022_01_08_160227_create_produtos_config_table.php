<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateProdutosConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos_config', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');

            $table->enum('ativo', ['S', 'N'])->nullable();
            $table->string('descricao', 96)->nullable();
            $table->string('descricao_alt', 96)->nullable();
            $table->string('codigo_barras', 96)->nullable();
            $table->integer('qtde_min', false)->nullable();
            $table->integer('qtde_max', false)->nullable();
            $table->enum('tipo', ['C', 'S', 'F', 'M', 'P', 'O'])->nullable();
            $table->enum('controla_estoque', ['N', 'S', 'L'])->nullable();
            $table->enum('movimentacao', ['C', 'V', 'A'])->nullable();
            $table->integer('unidade')->nullable();
            $table->string('codigo', 96)->nullable();
            $table->dateTime('ultima_atualizacao')->nullable();
            $table->string('descricao_completa', 96)->nullable();
            $table->double('preco_base', 8, 2)->nullable();
            $table->double('valor', 8, 2)->nullable();
            $table->double('valor_custo', 8, 2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos_config');
    }
}
