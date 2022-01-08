<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfResponsabilidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transf_responsabilidades', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor');

            $table->bigInteger('de');
            $table->bigInteger('para');
            $table->bigInteger('por');
            $table->dateTime('data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transf_responsabilidades');
    }
}
