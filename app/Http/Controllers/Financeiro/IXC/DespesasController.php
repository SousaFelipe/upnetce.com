<?php
namespace App\Http\Controllers\Financeiro\IXC;


use App\Repositories\Financeiro\DespesaRepo;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DespesasController extends Controller
{
    public function listar(Request $request)
    {
        $user =  Auth::user();

        $despesas = DespesaRepo::queryByPeriodo($user->provedor, $user->ixc_token, $request->periodo);

        return $this->json($despesas, 'despesas');
    }
}
