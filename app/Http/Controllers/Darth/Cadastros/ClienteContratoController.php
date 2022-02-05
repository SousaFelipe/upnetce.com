<?php
namespace App\Http\Controllers\Darth\Cadastros;


use App\Models\User;
use App\Models\Cadastros\ClienteContrato;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ClienteContratoController extends Controller
{
    public function listar(Request $request, ClienteContrato $cc)
    {
        if (($user = User::auth($request)) != false) {

            $contratos = $cc->assign($user->ixc_token)
                ->when('id_vendedor', '=', $user->id_ixc)
                ->orderBy('data')
                ->max(20)
                ->receive();

            return $this->json($contratos, 'contratos');
        }
        
        return $this->unauthorized();
    }


    public function criar(Request $request)
    {
        if (($user = User::auth($request)) != false) {
            
        }
        
        return $this->unauthorized();
    }


    public function editar(Request $request)
    {
        if (($user = User::auth($request)) != false) {
            
        }
        
        return $this->unauthorized();
    }


    public function remover(Request $request)
    {
        if (($user = User::auth($request)) != false) {
            
        }
        
        return $this->unauthorized();
    }   
}
