<?php
namespace App\Http\Controllers\Financeiro;


use App\Http\Controllers\Controller;

use App\Models\Financeiro\Categoria;
use App\Repositories\Financeiro\CategoriaRepo;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CategoriaController extends Controller
{
    public function mostrar(Request $request)
    {
        return view('financeiro.categorias', [
            'categoria' => $request->categoria
        ]);
    }



    public function subcategoria(Request $request)
    {
        $user = Auth::user();
        $categorias = CategoriaRepo::queryBySob($user->provedor, $request->categoria);

        return view('financeiro.categorias', [
            'categoria' => $request->categoria,
            'subcategoria' => $categorias
        ]);
    }



    public function listar(Request $request)
    {
        $user = Auth::user();
        $filters = $request->has('filters') ? $request->filters : [];

        $categorias = (count($filters) > 0)
            ? Categoria::where('provedor', $user->provedor)->where($filters)->get()
            : Categoria::where('provedor', $user->provedor)->get();

        $response = [
            'success' => ($categorias != null),
            'categorias' => $categorias
        ];

        return $this->json($response);
    }



    public function criar(Request $request)
    {
        $user = Auth::user();

        $categoria = CategoriaRepo::create([
            'id_ixc'    => $request->id_ixc,
            'provedor'  => $user->provedor,
            'user'      => $user->id,
            'categoria' => $request->categoria,
            'nome'      => $request->nome,
            'tipo'      => $request->tipo
        ]);

        $response = [
            'success' => ($categoria != null),
            'categoria' => $categoria
        ];

        return $this->json($response);
    }



    public function editar(Request $request)
    {
        
    }



    public function remover(Request $request)
    {
        
    }
}
