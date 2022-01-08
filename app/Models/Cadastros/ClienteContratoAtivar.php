<?php
namespace App\Models\Cadastros;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;


class ClienteContratoAtivar extends BaseModel
{
    protected $table = 'cliente_contrato_ativacoes';
    protected $srcname = 'cliente_contrato_ativar_cliente';
}
