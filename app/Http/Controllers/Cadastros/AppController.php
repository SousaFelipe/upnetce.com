<?php
namespace App\Http\Controllers\Cadastros;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class AppController extends Controller
{
    public function fornecedores(Request $request)
    {
        return view('cadastros.fornecedores');
    }
}
