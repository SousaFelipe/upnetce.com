<?php
namespace App\Http\Controllers\Financeiro\IXC;


use App\Models\Financeiro\Receita;
use App\Http\Controllers\Controller;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReceitasController extends Controller
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


    
    public function baixas(Request $request, Receita $receita)
    {
        $user = Auth::user();

        $recebidas = $receita->assign($user->ixc_token)
            ->grid([
                'TB' => $receita->target('status'),
                'OP' => '=',
                'P'  => 'R'
            ], [
                'TB' => $receita->target('pagamento_data'),
                'OP' => '>=',
                'P'  => Receita::carbonRange($request)['start']
            ], [
                'TB' => $receita->target('pagamento_data'),
                'OP' => '<=',
                'P'  => Receita::carbonRange($request)['final']
            ])
            ->orderBy('pagamento_data')
            ->max(100000)
            ->filter(self::$FILTER);

        $areceber = $receita->assign($user->ixc_token)
            ->grid([
                'TB' => $receita->target('status'),
                'OP' => '!=',
                'P'  => 'R'
            ], [
                'TB' => $receita->target('status'),
                'OP' => '!=',
                'P'  => 'C'
            ], [
                'TB' => $receita->target('data_vencimento'),
                'OP' => '>=',
                'P'  => Receita::carbonRange($request)['start']
            ], [
                'TB' => $receita->target('data_vencimento'),
                'OP' => '<=',
                'P'  => Receita::carbonRange($request)['final']
            ])
            ->orderBy('data_vencimento')
            ->max(100000)
            ->filter(self::$FILTER);

        $receitas = [
            'recebidas' => $recebidas,
            'areceber' => $areceber
        ];

        return $this->json($receitas, 'receitas');
    }
}
