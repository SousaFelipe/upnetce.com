<?php
namespace App\Repositories\Financeiro;


use App\Repositories\Repository;
use App\Models\Financeiro\Categoria;


class CategoriaRepo extends Repository
{
    public static function create(array $novaCategoria)
    {
        $categoria = Categoria::create($novaCategoria);
        return $categoria;
    }



    public static function queryAll($user)
    {
        $eloquent = self::bind(Categoria::class)
            ->assign($user->ixc_token);

        $categorias = $eloquent
            ->grid([
                'TB' => 'planejamento.planejamento',
                'OP' => 'L',
                'P'  => 'fornecedores'
            ])
            ->orderBy('id', 'asc')
            ->receive();

        return $categorias;
    }



    public static function queryByTipo($provedorID, $tipo, $orderBy = 'id', $sortOrder = 'asc')
    {
        return self::bind(Categoria::class)
            ->where('provedor', $provedorID)
            ->where('tipo', $tipo)
            ->orderBy($orderBy, $sortOrder)
            ->get();
    }



    public static function queryBySob($provedorID, $sobCategoriaID, $orderBy = 'id', $sortOrder = 'asc')
    {
        return self::bind(Categoria::class)
            ->where('provedor', $provedorID)
            ->where('categoria', $sobCategoriaID)
            ->orderBy($orderBy, $sortOrder)
            ->get();
    }
}
