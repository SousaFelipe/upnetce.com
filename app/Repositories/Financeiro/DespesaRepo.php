<?php
namespace App\Repositories\Financeiro;


use App\Repositories\Repository;
use App\Models\Financeiro\Despesa;


class DespesaRepo extends Repository
{
    public static function create(array $novaDespesa)
    {

    }



    public static function queryByPeriodo($provedor, $start, $end)
    {
        $eloquent = self::bind(Despesa::class)
            ->where('provedor', $provedor);

        $abertas = $eloquent
            ->where('status', 'A')
            ->whereBetween('data_abertura', [$start, $end])
            ->get();

        $agendadas = $eloquent
            ->where('status', 'A')
            ->whereBetween('data_agendamento', [$start, $end])
            ->get();

        $pagas = $eloquent
            ->where('status', 'P')
            ->whereBetween('data_baixa', [$start, $end])
            ->get();

        return [
            'abertas' => $abertas,
            'agendadas' => $agendadas,
            'pagas' => $pagas,
        ];
    }
}
