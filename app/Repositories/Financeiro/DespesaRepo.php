<?php
namespace App\Repositories\Financeiro;


use App\Repositories\Repository;
use App\Models\Financeiro\Despesa;


class DespesaRepo extends Repository
{
    private static $FILTER = [
        'codigo_barras',
        'data_cancelamento',
        'data_emissao',
        'data_pagamento',
        'data_vencimento',
        'debido_data',
        'documento',
        'filial_id',
        'id',
        'id_conta',
        'id_contas',
        'id_entrada',
        'id_fornecedor',
        'obs',
        'previsao',
        'status',
        'tipo_pagamento',
        'valor',
        'valor_aberto',
        'valor_cancelado',
        'valor_pago',
        'valor_total_pago'
    ];



    public static function create(array $novaDespesa)
    {
        
    }



    public static function sync(array $dessincronizado)
    {

    }



    public static function queryByPeriodo($user, $start, $final)
    {
        $eloquent = self::bind(Despesa::class)
            ->assign($user->ixc_token);
        
        $despesas = [

            'canceladas' => $eloquent
                ->grid([
                    'TB' => 'fn_apagar.status',
                    'OP' => '=',
                    'P'  => 'C'
                ], [
                    'TB' => 'fn_apagar.data_vencimento',
                    'OP' => '>=',
                    'P'  => $start
                ], [
                    'TB' => 'fn_apagar.data_vencimento',
                    'OP' => '<=',
                    'P'  => $final
                ])
                ->max(10000)
                ->orderBy('data_cancelamento', 'asc')
                ->filter(self::$FILTER),

            'em_aberto' => $eloquent
                ->grid([
                    'TB' => 'fn_apagar.status',
                    'OP' => '=',
                    'P'  => 'A'
                ], [
                    'TB' => 'fn_apagar.data_vencimento',
                    'OP' => '>=',
                    'P'  => $start
                ], [
                    'TB' => 'fn_apagar.data_vencimento',
                    'OP' => '<=',
                    'P'  => $final
                ])
                ->max(10000)
                ->orderBy('data_vencimento', 'asc')
                ->filter(self::$FILTER),

            'pagas' => $eloquent
                ->grid([
                    'TB' => 'fn_apagar.status',
                    'OP' => '=',
                    'P'  => 'F'
                ], [
                    'TB' => 'fn_apagar.data_pagamento',
                    'OP' => '>=',
                    'P'  => $start
                ], [
                    'TB' => 'fn_apagar.data_pagamento',
                    'OP' => '<=',
                    'P'  => $final
                ])
                ->max(10000)
                ->orderBy('data_pagamento', 'asc')
                ->filter(self::$FILTER),

        ];

        return $despesas;
    }
}
