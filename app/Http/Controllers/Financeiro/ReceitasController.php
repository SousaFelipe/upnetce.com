<?php
namespace App\Http\Controllers\Financeiro;


use App\Http\Controllers\Controller;

use App\Models\Financeiro\Receita;
use App\Repositories\Financeiro\ReceitaRepo;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class ReceitasController extends Controller
{
    public function listar(Request $request)
    {
        if (($user = Auth::user()) != null) {

            $eloquent = Receita::where('provedor', $user->provedor);
            $start = Carbon::parse('1 ' . $request->periodo)->toDateString();
            $end = Carbon::parse($request->periodo)->endOfMonth()->toDateString();

            $local = [

                'areceber' => $eloquent
                    ->where('status', 'A')
                    ->whereBetween('data_vencimento', [$start, $end])
                    ->get(),

                'recebidas' => $eloquent
                    ->where('status', 'R')
                    ->whereBetween('pagamento_data', [$start, $end])
                    ->get()

            ];

            $receitas = [
                'local' => $local,
                'remote' => ReceitaRepo::query($user, $start, $end)
            ];

            return $this->json($receitas, 'receitas');
        }
    }
}
