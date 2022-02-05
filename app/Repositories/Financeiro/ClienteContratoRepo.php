<?php
namespace App\Repositories\Financeiro;


use App\Models\Cadastros\ClienteContrato;

use App\Repositories\Repository;
use App\Repositories\Financeiro\VdContratoRepo;


class ClienteContratoRepo extends Repository
{
    public static function queryByCliente($provedor, $token, $cliente, $fetchPlano = false)
    {
        $contratos = self::bind(ClienteContrato::class)
            ->assign($token)
            ->when('id_cliente', '=', $cliente)
            ->orderBy('id')
            ->filter([
                'id', 
                'id_vd_contrato',
                'status',
                'status_internet'
            ]);

        if ($fetchPlano) {
            for ($c = 0; $c < count($contratos); $c++) { 
                $contratos[$c]['plano'] = VdContratoRepo::queryByContrato($provedor, $token, $contratos[$c]['id_vd_contrato']);
            }
        }

        return $contratos;
    }
}
