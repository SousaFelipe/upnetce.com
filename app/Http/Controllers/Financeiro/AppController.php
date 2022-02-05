<?php
namespace App\Http\Controllers\Financeiro;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class AppController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('financeiro.dashboard');
    }



    public function planilhas(Request $request)
    {
        return view('financeiro.planilhas');
    }



    public function receitas(Request $request)
    {
        return view('financeiro.receitas');
    }



    public function despesas(Request $request)
    {
        return view('financeiro.despesas');
    }
}
