<?php
namespace App\Models\Financeiro;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Categoria extends Model
{
    use HasFactory;

    
    public $timestamps = false;

    protected $table = 'categorias';


    protected $fillable = [
        'provedor',
        'user',
        'categoria',
        'nome',
        'tipo'
    ];
}
