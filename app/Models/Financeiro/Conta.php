<?php
namespace App\Models\Financeiro;


use App\Models\BaseModel;


class Conta extends BaseModel
{
    public $timestamps = false;
    
    protected $srcname = 'contas';
}
