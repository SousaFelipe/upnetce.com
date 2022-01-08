<?php
namespace App\Models\Cadastros;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\BaseModel;


class ClienteContrato extends BaseModel
{
    protected $table = 'cliente_contratos';
    protected $srcname = 'cliente_contrato';
}
