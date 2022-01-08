<?php
namespace App\Http\Controllers\API\ClearMAC;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\ClienteContrato;
use App\Models\Cadastros\Contratos\VdContrato;
use App\Models\Provedor\RadUsuario;


class ClienteController extends Controller
{
    public function listar(Request $request, Cliente $cliente)
    {
        if ($this->csrfBroken($request)) {
            return $this->unauthorized();
        }

        $queryValue = $request->slug;
        $queryType = $this->getQueryType($queryValue);
        $oper = (($queryType == 'cnpj_cpf') ? '=' : 'LE');

        if (($queryType === 'cnpj_cpf') && Cliente::isInvalidCPF($queryValue)) {
            return $this->json(['error' => 'CPF']);
        }

        $clientes = $cliente->when($queryType, $oper, $queryValue)
            ->orderBy($queryType)
            ->max(20)
            ->filter(['id', 'razao', 'endereco']);

        return $this->json(
            $this->fetchContratosLogins($clientes), 'clientes'
        );
    }



    private function fetchContratosLogins($clientes)
    {
        $cc = new ClienteContrato();
        $radius = new RadUsuario();

        for ($i = 0; $i < count($clientes); $i++) {

            $clientes[$i]['contratos'] = $this->getPlano(
                $cc->when('id_cliente', '=', $clientes[$i]['id'])
                    ->orderBy('id')
                    ->filter(['id', 'id_vd_contrato', 'status', 'status_internet'])
            );

            $clientes[$i]['logins'] = $radius->when('id_cliente', '=', $clientes[$i]['id'])
                ->filter(['id', 'mac', 'login', 'senha', 'online']);
        }

        return $clientes;
    }



    private function getPlano($contratos)
    {
        $vd_contratos = new VdContrato();

        for ($i = 0; $i < count($contratos); $i++) {
            $contratos[$i]['plano'] = $vd_contratos->when('id', '=', $contratos[$i]['id_vd_contrato'])->filter(['id', 'nome', 'descricao']);
        }

        return $contratos;
    }



    private function getQueryType($query)
    {
        $clearQuery = preg_replace('/[^0-9]/is', '', $query);
        $queryLen = strlen($clearQuery);
        return (($queryLen > 0 && $queryLen <= 14) && is_numeric($clearQuery)) ? 'cnpj_cpf' : 'razao';
    }
}
