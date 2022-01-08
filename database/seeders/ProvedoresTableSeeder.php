<?php
namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class ProvedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('provedores')->insert([
            'id'                => 1,

            'cnpj'              => '23866988000171',
            'razao'             => 'Upnet Tecnologia e Informacao Eireli',
            'nome_fantasia'     => 'Agility Telecom',
            'data_abertura'     => '2015-12-18',
            'porte'             => 'Micro Empresa',
            'contatos'          => '88981748895;88981691983',
            'tipo'              => 'Matriz',
            'situacao'          => 'Ativa',
            'data_situacao'     => '2015-02-18',

            'logradouro'        => 'Rua Conego Aureliano Mota, 96',
            'bairro'            => 'Centro',
            'cep'               => '63800000',
            'municipio'         => 'Quixeramobim',
            'uf'                => 'CE',

            'titular'           => 'Gabriel Araujo de Almeida Costa',
            'titular_contato'   => '88981748895',
            'class_responsavel' => 'Titular Pessoa Física Residente ou Domiciliado no Brasil',

            'ativo'             => 'S',

            'ixc_token'         => '6:d94f8ccff332c49a266088ea3e0afaa2bdac77157bc4c698d7ab7e35971192bd'
        ]);
    }
}
