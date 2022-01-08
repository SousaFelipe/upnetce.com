<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');

            $table->bigInteger('modelo');
            $table->integer('estq_atual', false)->length(11)->unsigned();

            $table->bigInteger('id_ixc')->nullable();
            $table->enum('ativo', ['S', 'N'])->default('S');
            $table->string('descricao', 96);
            $table->string('descricao_alt', 96)->nullable();
            $table->string('codigo_barras', 96)->nullable();
            $table->integer('qtde_min', false)->length(11)->unsigned();
            $table->integer('qtde_max', false)->length(11)->unsigned();
            $table->enum('tipo', ['C', 'S', 'F', 'M', 'P', 'O']);
            $table->enum('controla_estoque', ['N', 'S', 'L']);
            $table->enum('movimentacao', ['C', 'V', 'A']);
            $table->integer('unidade')->length(11)->unsigned();
            $table->string('codigo', 96)->nullable();
            $table->dateTime('ultima_atualizacao')->nullable();
            $table->string('descricao_completa', 96)->nullable();
            $table->double('preco_base', 8, 2);
            $table->double('valor', 8, 2);
            $table->double('valor_custo', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
