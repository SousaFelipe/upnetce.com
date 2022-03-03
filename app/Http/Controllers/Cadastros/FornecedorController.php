<?php
namespace App\Http\Controllers\Cadastros;


use App\Http\Controllers\Controller;

use App\Models\Cadastros\Fornecedor;
use App\Repositories\Cadastros\FornecedorRepo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class FornecedorController extends Controller
{
    public function listar(Request $request)
    {
        if (($user = Auth::user()) != null) {

            $clausulas = $request->query();
            $eloquent = Fornecedor::where('provedor', $user->provedor);

            $fornecedores = (count($clausulas) > 0)
                ? $eloquent->where($clausulas)->get()
                : $eloquent->get();

            $response = [
                'success' => ($fornecedores != null),
                'fornecedores' => $fornecedores
            ];

            return $this->json($response);
        }

        return $this->unauthorized();
    }



    public function criar(Request $request)
    {
    }



    public function editar(Request $request)
    {
        if (($user = Auth::user()) != null) {

            $rows = Fornecedor::where('provedor', $user->provedor)
                ->where('id_ixc', $request->id_fornecedor)
                ->update($request->except('id_fornecedor'));

            return $this->json([
                'success' => $rows > 0
            ]);
        }

        return $this->unauthorized();
    }



    public function sync(Request $request)
    {
        if (($user = Auth::user()) != null) {
            return $this->json([
                'success' => FornecedorRepo::syncDown($user, $request->id_fornecedor)
            ]);
        }

        return $this->unauthorized();
    }



    public function remover(Request $request)
    {
    }
}
