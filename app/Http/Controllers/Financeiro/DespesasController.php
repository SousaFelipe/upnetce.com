<?php
namespace App\Http\Controllers\Financeiro;


use App\Repositories\Financeiro\DespesaRepo;
use App\Http\Controllers\Controller;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DespesasController extends Controller
{
    public function listar(Request $request)
    {
        $despesas = [
            'abertas' => [],
            'agendadas' => [],
            'pagas' => []
        ];

        if ($request->periodo == 0) {

        }
        else {
            $periodo = '1 ' . $request->periodo;

            $start = Carbon::parse($periodo)->toDateTimeString();
            $end = Carbon::parse($request->periodo)->subMonthsNoOverflow()->endOfMonth()->toDateTimeString();

            $despesas = DespesaRepo::queryByPeriodo(Auth::user()->provedor, $start, $end);
        }

        return $this->json($despesas, 'despesas');
    }
}
