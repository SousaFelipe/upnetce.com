<?php
namespace App\Repositories\Financeiro;


use App\Repositories\Repository;

use App\Models\Provedor\RadUsuario;


class VdContratoRepo extends Repository
{
    public static function queryByContrato($provedor, $token, $id_vd_contrato)
    {
        return self::bind(RadUsuario::class)
            ->assign($token)
            ->when('id', '=', $id_vd_contrato)
            ->filter(['id', 'nome', 'descricao']);
    }
}