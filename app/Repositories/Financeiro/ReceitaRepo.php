<?php
namespace App\Repositories\Financeiro;


use App\Repositories\Repository;
use App\Models\Financeiro\Receita;


class ReceitaRepo extends Repository
{
    public static function create(array $novaReceita)
    {

    }



    public static function queryByPeriodo($provedor, $start, $end)
    {
        $eloquent = self::bind(Receita::class)
            ->where('provedor', $provedor);

        $areceber = $eloquent
            ->where('status', 'A')
            ->whereBetween('data_agendamento', [$start, $end])
            ->get();

        $recebidas = $eloquent
            ->where('status', 'R')
            ->whereBetween('data_baixa', [$start, $end])
            ->get();

        return [
            'areceber' => $areceber,
            'recebidas' => $recebidas,
        ];
    }
}
