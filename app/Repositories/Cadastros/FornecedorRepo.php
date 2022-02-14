<?php
namespace App\Repositories\Cadastros;


use App\Repositories\Repository;
use App\Models\Cadastros\Fornecedor;


class FornecedorRepo extends Repository
{
    public static function sync($user, $f)
    {
        $fornecedor = Fornecedor::create([
            'id_ixc'            => $f['id'],
            'provedor'          => $user->provedor,
            'user'              => $user->id,
            'ativo'             => $f['ativo'],
            'bairro'            => $f['bairro'],
            'celular'           => $f['celular'],
            'cep'               => $f['cep'],
            'cidade'            => $f['cidade'],
            'contribuinte_icms' => $f['contribuinte_icms'],
            'cpf_cnpj'          => $f['cpf_cnpj'],
            'data'              => $f['data'],
            'email'             => $f['email'],
            'endereco'          => $f['endereco'],
            'fantasia'          => $f['fantasia'],
            'razao'             => $f['razao'],
            'sync'              => 'S',
            'titulo'            => $f['razao']
        ]);

        return $fornecedor != null;
    }



    public static function queryAll($user, $slug = false)
    {
        $eloquent = self::bind(Fornecedor::class)
            ->assign($user->ixc_token);

        $query = ($slug != false)
            ? $eloquent->when('razao', 'L', $slug)
            : $eloquent->when('id', '>=', 1);
        
        return $query
            ->max(1000)
            ->orderBy('razao', 'asc')
            ->receive();
    }
}