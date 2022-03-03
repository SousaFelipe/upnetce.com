<?php
namespace App\Models\Cadastros;


use App\Models\BaseModel;


class Fornecedor extends BaseModel
{
    public $timestamps = false;

    protected $table = 'fornecedores';
    protected $srcname = 'fornecedor';


    protected $fillable = [
        'id',
        'id_ixc',
        'provedor',
        'user',
        'ativo',
        'bairro',
        'complemento',
        'celular',
        'cep',
        'cidade',
        'contribuinte_icms',
        'cpf_cnpj',
        'data',
        'email',
        'endereco',
        'fantasia',
        'razao',
        'titulo',
        'sincronizado_em',
        'atualizado_em'
    ];
}
