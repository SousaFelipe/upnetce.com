<?php
namespace App\Http\Controllers\Cadastros\IXC;


use App\Http\Controllers\Controller;
use App\Repositories\Cadastros\ClienteRepo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ClienteController extends Controller
{
    public function listar(Request $request)
    {
        $user = Auth::user();

        $clientes = ClienteRepo::queryBySlug(
            $user->provedor,
            $user->ixc_token,
            $request->slug,
            true,
            true
        );

        return $this->json($clientes, 'clientes');
    }
}

