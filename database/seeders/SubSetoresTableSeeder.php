<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SubSetoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_setores')->insert([
            'id'        => 1,
            'provedor'  => 1,
            'setor'     => 2,
            'nome'      => 'Estoque'
        ]);

        DB::table('sub_setores')->insert([
            'id'        => 2,
            'provedor'  => 1,
            'setor'     => 2,
            'nome'      => 'Projetos'
        ]);

        DB::table('sub_setores')->insert([
            'id'        => 3,
            'provedor'  => 1,
            'setor'     => 2,
            'nome'      => 'Suporte'
        ]);

        DB::table('sub_setores')->insert([
            'id'        => 4,
            'provedor'  => 1,
            'setor'     => 2,
            'nome'      => 'Frotas',
        ]);
    }
}
