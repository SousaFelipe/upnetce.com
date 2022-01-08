<?php
namespace App\Http\Controllers\API\ClearMAC;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Provedor\RadUsuario;


class RadUsuariosController extends Controller
{
    public function find(Request $request, RadUsuario $rad)
    {
        if ($this->csrfBroken($request)) {
            return $this->unauthorized();
        }

        $logins = $rad->when('id_cliente', '=', $request->id_cliente)->filter(['id', 'mac', 'login', 'senha', 'online']);

        return $this->json($logins, 'logins');
    }



    public function clear(Request $request, RadUsuario $rad)
    {
        if ($this->csrfBroken($request)) {
            return $this->unauthorized();
        }

        $logins = $rad->match($request->id_login)->receive();
        $response = array();

        if (isset($logins[0])) {

            $login = $logins[0];
            $login["mac"] = "";

            $response = $rad->change($login, $login["id"]);
        }

        return $this->json($response);
    }
}
