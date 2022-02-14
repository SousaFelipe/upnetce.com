<?php
namespace App\Repositories\Financeiro;


use App\Repositories\Repository;
use App\Models\Financeiro\Receita;


class ReceitaRepo extends Repository
{
    private static $FILTER = [
        'id',
        'id_ixc',
        'id_cliente',
        'id_contrato',
        'id_cobranca',
        'id_carteira_cobranca',
        'filial_id',
        'documento',
        'data_emissao',
        'data_cancelamento',
        'baixa_data',
        'pagamento_data',
        'data_vencimento',
        'pagamento_valor',
        'valor',
        'valor_aberto',
        'valor_cancelado',
        'valor_recebido',
        'previsao',
        'obs'
    ];


    public static function query($user, $start, $final)
    {
        $eloquent = self::bind(Receita::Class)->assign($user->ixc_token);

        $areceber = $eloquent
            ->grid([
                'TB' => 'fn_areceber.status',
                'OP' => '!=',
                'P'  => 'R'
            ], [
                'TB' => 'fn_areceber.status',
                'OP' => '!=',
                'P'  => 'C'
            ], [
                'TB' => 'fn_areceber.data_vencimento',
                'OP' => '>=',
                'P'  => $start
            ], [
                'TB' => 'fn_areceber.data_vencimento',
                'OP' => '<=',
                'P'  => $final
            ])
            ->orderBy('data_vencimento')
            ->max(100000)
            ->filter(self::$FILTER);

        $recebidas = $eloquent
            ->grid([
                'TB' => 'fn_areceber.status',
                'OP' => '=',
                'P'  => 'R'
            ], [
                'TB' => 'fn_areceber.pagamento_data',
                'OP' => '>=',
                'P'  => $start
            ], [
                'TB' => 'fn_areceber.pagamento_data',
                'OP' => '<=',
                'P'  => $final
            ])
            ->orderBy('pagamento_data')
            ->max(100000)
            ->filter(self::$FILTER);

        return [
            'areceber' => $areceber,
            'recebidas' => $recebidas
        ];
    }
}
