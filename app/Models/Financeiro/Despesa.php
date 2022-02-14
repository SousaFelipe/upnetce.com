<?php
namespace App\Models\Financeiro;


use Illuminate\Support\Carbon;

use App\Models\BaseModel;


class Despesa extends BaseModel
{
    protected $table = 'despesas';
    protected $srcname = 'fn_apagar';



    public static function LE($date = 0)
    {
        $fullDate = Carbon::parse('1 ' . (($date != 0) ? $date : 'January'))->toDateString();
        $explDate = explode('-', $fullDate);
        
        return ($date == 0)
            ? $explDate[0]
            : $explDate[0] . '-' . $explDate[1];
    }



    public static function carbonRange($periodo)
    {
        return [

            'start' => ($periodo == 0)
                ? Carbon::now()->startOfYear()->toDateString()
                : Carbon::parse('1 ' . $periodo)->toDateString(),

            'final' => ($periodo == 0)
                ? Carbon::now()->endOfYear()->toDateString()
                : Carbon::parse($periodo)->endOfMonth()->toDateString()
        ];
    }
}
