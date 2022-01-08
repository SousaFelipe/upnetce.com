<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateSubSetoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_setores', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');
            $table->string('setor', 96);
            $table->string('slug', 45);
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
        Schema::dropIfExists('sub_setores');
    }
}
