<?php
namespace App\Repositories\Provedor;


use App\Repositories\Repository;

use App\Models\Provedor\RadUsuario;


class LoginRepo extends Repository
{
    public static function queryByCliente($provedor, $token, $cliente)
    {
        return self::bind(RadUsuario::class)
            ->assign($token)
            ->when('id_cliente', '=', $cliente)
            ->filter([
                'id',
                'mac',
                'login',
                'senha',
                'online'
            ]);
    }
}