<?php
namespace App\Http\Controllers\Suporte\IXC;


use App\Repositories\Suporte\OrdemDeServicoRepo;

use App\Http\Controllers\Controller;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OsController extends Controller
{
    public function listar(Request $request)
    {
        $auth = Auth::user();

        $oss = OrdemDeServicoRepo::queryAbertasByCliente($auth->provedor, $auth->ixc_token, $request->id_cliente);

        return $this->json($oss, 'ordens_de_servico');
    }
}
