<?php
namespace App\Models\Financeiro;


use Illuminate\Support\Carbon;

use App\Models\BaseModel;


class Receita extends BaseModel
{
    protected $table = 'receitas';
    protected $srcname = 'fn_areceber';



    public static function LE($date = 0)
    {
        $fullDate = Carbon::parse('1 ' . (($date != 0) ? $date : 'January'))->toDateString();
        $explDate = explode('-', $fullDate);
        
        return ($date == 0)
            ? $explDate[0]
            : $explDate[0] . '-' . $explDate[1];
    }



    public static function carbonRange($request)
    {
        return [

            'start' => ($request->periodo == 0)
                ? Carbon::now()->startOfYear()->toDateString()
                : Carbon::parse('1 ' . $request->periodo)->toDateString(),

            'final' => ($request->periodo == 0)
                ? Carbon::now()->endOfYear()->toDateString()
                : Carbon::parse($request->periodo)->endOfMonth()->toDateString()
        ];
    }
}
