<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ColaboradoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colaboradores')->insert([
            'id'                => 1,

            'provedor'          => 1,
            'setor'             => 2,

            'code'              => '3Fgb8sdf',
            'filial_id'         => 1,

            'id_ixc'            => 8,
            'funcionario'       => 8,
            'id_funcao'         => 3,
            'id_departamento'   => 1,
            'ativo'             => 'S',
            'cpf_cnpj'          => '02507608358',
            'fone_celular'      => '88981881375',
            'fone_emergencia'   => '88998344033',
            'email'             => 'flpssdocarmo0@gmail.com ',
            'salario'           => 1380,
        ]);
    }
}
