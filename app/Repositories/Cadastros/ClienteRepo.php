<?php
namespace App\Repositories\Cadastros;


use App\Repositories\Repository;
use App\Repositories\Financeiro\ClienteContratoRepo;
use App\Repositories\Provedor\LoginRepo;
use App\Repositories\Suporte\OrdemDeServicoRepo;

use App\Models\Cadastros\Cliente;


class ClienteRepo extends Repository
{
    private static $FILTER = [
        'id',
        'ativo',
        'razao',
        'cnpj_cpf',
        'ie_identidade',
        'data_nascimento',
        'telefone_celular',
        'whatsapp',
        'endereco',
        'complemento',
        'bairro',
        'cidade',
        'uf',
        'cep',
        'Sexo',
        'alerta',
        'obs'
    ];



    public static function queryBySlug($provedor, $token, $query, $max = 20)
    {
        $queryType = self::getQueryType($query);
        $oper = (($query == 'cnpj_cpf') ? '=' : 'LE');

        $clientes = self::bind(Cliente::class)
            ->assign($token)
            ->when($queryType, $oper, $query)
            ->orderBy($queryType)
            ->max($max)
            ->filter(self::$FILTER);

        for ($i = 0; $i < count($clientes); $i++) {
            
            $contratos = ClienteContratoRepo::queryByCliente($provedor, $token, $clientes[$i]['id'], true);
            $clientes[$i]['contratos'] = $contratos;

            $logins = LoginRepo::queryByCliente($provedor, $token, $clientes[$i]['id']);
            $clientes[$i]['logins'] = $logins;

            $oss = OrdemDeServicoRepo::queryAbertasByCliente($provedor, $token, $clientes[$i]['id']);
            $clientes[$i]['ordens_de_servico'] = $oss;
        }

        return $clientes;
    }



    public static function getQueryType($query)
    {
        $clearQuery = preg_replace('/[^0-9]/is', '', $query);
        $queryLen = strlen($clearQuery);
        return (($queryLen > 0 && $queryLen <= 14) && is_numeric($clearQuery)) ? 'cnpj_cpf' : 'razao';
    }
}
