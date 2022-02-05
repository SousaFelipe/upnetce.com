<?php
namespace App\Http\Controllers\Darth\Cadastros;


use App\Models\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ClienteController extends Controller
{
    public function listar(Request $request)
    {
        if (($user = User::auth($request)) != false) {
            

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
