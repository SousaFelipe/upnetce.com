<?php
namespace App\Http\Controllers\Financeiro;


use App\Models\Financeiro\Despesa;
use App\Repositories\Financeiro\DespesaRepo;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class DespesasController extends Controller
{
    public function listar(Request $request)
    {
        $user =  Auth::user();
        $start = Carbon::parse('1 ' . $request->periodo)->toDateString();
        $final = Carbon::parse($request->periodo)->endOfMonth()->toDateString();

        $local = [

            'canceladas' => Despesa::where('provedor', $user->provedor)
                ->where('status', 'C')
                ->whereBetween('data_vencimento', [$start, $final])
                ->get(),

            'em_aberto' => Despesa::where('provedor', $user->provedor)
                ->where('status', 'A')
                ->whereBetween('data_vencimento', [$start, $final])
                ->get(),

            'pagas' => Despesa::where('provedor', $user->provedor)
                ->where('status', 'F')
                ->where('valor_total_pago', '>', 0)
                ->whereBetween('data_pagamento', [$start, $final])
                ->get()
        ];

        $despesas = [
            'local' => $local,
            'remote' => DespesaRepo::queryByPeriodo($user, $start, $final)
        ];

        return $this->json($despesas, 'despesas');
    }



    public function criar(Request $request)
    {
        if (($user = Auth::user()) != null) {

            $despesa = Despesa::create([
                'filial_id'         => $user->filial_id,
                'provedor'          => $user->provedor,
                'user'              => $user->id,
                'categoria'         => $request['sob_categoria'],
                'despesa'           => $request['sob_despesa'],
                'orcamento'         => $request['orcamento'],
                'codigo_barras'     => $request['codigo_barras'],
                'valor_aberto'      => $request['valor'],
                'tipo_pagamento'    => $request['tipo_pagamento'],
                'data_emissao'      => $request['data_emissao'],
                'data_vencimento'   => $request['data_vencimento'],
                'valor'             => $request['valor'],
                'documento'         => $request['documento'],
                'id_conta'          => $request['categoria'],
                'id_contas'         => $request['conta_caixa'],
                'id_fornecedor'     => $request['id_fornecedor'],
                'obs'               => $request['obs'],
            ]);
    
            return $this->json([
                'success' => $despesa != null,
                'despesa' => $despesa
            ]);
        }

        return $this->unauthorized();
    }
}
