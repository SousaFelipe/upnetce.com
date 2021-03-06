<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('provedor')->nullable();
            $table->bigInteger('id_ixc');
            $table->enum('tipo', ['U', 'V'])->default('U');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('ixc_token', 66)->unique();
            $table->dateTime('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
