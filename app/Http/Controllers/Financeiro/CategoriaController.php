<?php
namespace App\Http\Controllers\Financeiro;


use App\Repositories\Financeiro\CategoriaRepo;
use App\Http\Controllers\Controller;

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
        $categorias = CategoriaRepo::queryBySob(Auth::user()->provedor, $request->categoria);

        return view('financeiro.categorias', [
            'categoria' => $request->categoria,
            'subcategoria' => $categorias
        ]);
    }



    public function listar(Request $request)
    {
        $params = $request->params;

        $categorias = $request->has('filters')
            ? CategoriaRepo::queryAll($request->provedor, $request->filters)
            : CategoriaRepo::queryAll($request->provedor, []);

        $response = [
            'success' => ($categorias != null),
            'categorias' => $categorias
        ];

        return $this->json($response);
    }



    public function criar(Request $request)
    {
        $categoria = CategoriaRepo::create([
            'provedor'  => $request->provedor,
            'user'      => $request->user,
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
