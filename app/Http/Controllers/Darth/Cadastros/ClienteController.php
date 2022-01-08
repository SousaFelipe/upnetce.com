<?php
namespace App\Http\Controllers\Darth\Cadastros;


use App\Models\User;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;


class ClienteController extends Controller
{
    public function buscar (Request $request)
    {
        $user = User::auth($request);
    }
}
