<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class SetoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setores')->insert([
            'provedor'  => 1,
            'slug'      => 'admin',
            'icone'     => 'account-tie',
            'access'    => 'AD',
            'nome'      => 'Administrativo',
            'descricao' => 'Gestão colaboradores, folhas de pagamento e recursos humanos.'
        ]);

        DB::table('setores')->insert([
            'provedor'  => 1,
            'access'    => 'OP',
            'slug'      => 'operacional',
            'icone'     => 'hexagon-multiple',
            'nome'      => 'Operacional',
            'descricao' => 'Gestão e desenvolvimento de processos internos e externos.'
        ]);

        DB::table('setores')->insert([
            'provedor'  => 1,
            'access'    => 'FN',
            'slug'      => 'financeiro',
            'icone'     => 'finance',
            'nome'      => 'Financeiro',
            'descricao' => 'Administração financeiro relacionado ao setor principal do colaborador.'
        ]);

        DB::table('setores')->insert([
            'provedor'  => 1,
            'access'    => 'CX',
            'slug'      => 'caixa',
            'icone'     => 'cash-register',
            'nome'      => 'Caixa',
            'descricao' => 'Acesso a dados contratuais e cadastrais dos clientes da base.'
        ]);
    }
}
