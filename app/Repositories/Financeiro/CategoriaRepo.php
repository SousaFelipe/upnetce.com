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



    public static function queryAll($provedorID, $filters = [])
    {
        $eloquent = self::bind(Categoria::class)
            ->where('provedor', $provedorID);

        return (count($filters) > 0)
            ? $eloquent->where($filters)->get()
            : $eloquent->get();
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
