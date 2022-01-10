<?php
namespace App\Http\Controllers\Darth\Cadastros;


use App\Models\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ClienteController extends Controller
{
    public function listar(Request $request)
    {
        $user = User::auth($request);

        return $this->json($user, 'user');
    }


    public function criar(Request $request)
    {
        $user = User::auth($request);
    }


    public function editar(Request $request)
    {
        $user = User::auth($request);
    }


    public function remover(Request $request)
    {
        $user = User::auth($request);
    }
}
