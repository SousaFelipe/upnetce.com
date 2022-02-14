<?php
namespace App\Http\Controllers\Financeiro;


use App\Http\Controllers\Controller;

use App\Models\Financeiro\Conta;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ContaController extends Controller
{
    public function listar(Request $request, Conta $conta)
    {
        $user = Auth::user();

        $contas = $conta->assign($user->ixc_token)
            ->grid([
                'TB' => $conta->target('id'),
                'OP' => '>=',
                'P'  => '1'
            ])
            ->receive();
        
        return $this->json($contas, 'contas');
    }
}
