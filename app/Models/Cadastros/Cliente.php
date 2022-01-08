<?php
namespace App\Models\Cadastros;


use App\Models\BaseModel;


class Cliente extends BaseModel
{
    protected $table = 'clientes';
    protected $srcname = 'cliente';



    public static function isInvalidCPF($cpf) {

        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );

        if (strlen($cpf) != 11) {
            return true;
        }

        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return true;
        }

        for ($t = 9; $t < 11; $t++) {

            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }

            $d = ((10 * $d) % 11) % 10;

            if ($cpf[$c] != $d) {
                return true;
            }
        }

        return false;
    }
}
