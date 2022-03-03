<?php
namespace App\Repositories\Cadastros;


use App\Repositories\Repository;
use App\Models\Cadastros\Fornecedor;

use Illuminate\Support\Carbon;


class FornecedorRepo extends Repository
{
    public static function syncUp($user, $id_ixc)
    {
        $eloquent = self::bind(Fornecedor::class)->assign($user->ixc_token);

        $local = $eloquent
            ->where('provedor', $user->provedor)
            ->where('id_ixc', $id_ixc)
            ->first();

        $response = $eloquent->change($local, $id_ixc);

        return $response;
    }



    public static function syncDown($user, $id_ixc)
    {
        $eloquent = self::bind(Fornecedor::class)->assign($user->ixc_token);
        $remote = $eloquent->match($id_ixc);

        $sync = [
            'id_ixc'            => $remote['id'],
            'ativo'             => $remote['ativo'],
            'bairro'            => $remote['bairro'],
            'celular'           => $remote['celular'],
            'cep'               => $remote['cep'],
            'cidade'            => $remote['cidade'],
            'contribuinte_icms' => $remote['contribuinte_icms'],
            'cpf_cnpj'          => $remote['cpf_cnpj'],
            'data'              => $remote['data'],
            'email'             => $remote['email'],
            'endereco'          => $remote['endereco'],
            'fantasia'          => $remote['fantasia'],
            'razao'             => $remote['razao']
        ];

        if ($eloquent->where('id_ixc', $id_ixc)->count() > 0) {
            $sync['sincronizado_em'] = Carbon::now();
            
            $rows = $eloquent
                ->where('id_ixc', $id_ixc)
                ->update($sync);
            
            return $rows > 0;
        }
        
        $new = Fornecedor::create($sync);

        return $new != null;
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