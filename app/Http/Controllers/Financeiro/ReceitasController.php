<?php
namespace App\Http\Controllers\Financeiro;


use App\Repositories\Financeiro\ReceitaRepo;
use App\Http\Controllers\Controller;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ReceitasController extends Controller
{
    public function listar(Request $request)
    {
        $receitas = [
            'areceber' => [],
            'recebidas' => []
        ];

        if ($request->periodo == 0) {

        }
        else {
            $periodo = '1 ' . $request->periodo;

            $start = Carbon::parse($periodo)->toDateTimeString();
            $end = Carbon::parse($request->periodo)->subMonthsNoOverflow()->endOfMonth()->toDateTimeString();

            $receitas = ReceitaRepo::queryByPeriodo(Auth::user()->provedor, $start, $end);
        }

        return $this->json($receitas, 'receitas');
    }
}
