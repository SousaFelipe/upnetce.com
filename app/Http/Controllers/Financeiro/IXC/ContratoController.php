<?php
namespace App\Http\Controllers\Financeiro\IXC;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Cadastros\Cliente;
use App\Models\Cadastros\ClienteContrato;
use App\Models\Cadastros\ClienteContratoAtivar;

use App\Models\Cadastros\Contratos\VdContrato;



class ContratoController extends Controller
{
    public function listar(Request $request, ClienteContrato $cc)
    {
        if ($this->csrfBroken($request)) {
            return $this->unauthorized();
        }

        $contratos = $cc->when('id_cliente', '=', $request->id_cliente)
            ->orderBy('id_cliente')
            ->max(20)
            ->filter(['id', 'id_vd_contrato', 'status', 'status_internet']);

        return $this->json(
            $this->pushPlano($contratos), 'contratos'
        );
    }



    public function ativar(Request $request, ClienteContratoAtivar $cca)
    {
        if ($this->csrfBroken($request)) {
            return $this->unauthorized();
        }

        $ativacao = $cca->send([
            'qtype'         => 'cliente_contrato_ativar_cliente.id',
            'id_contrato'   => $request->id_contrato
        ]);

        $ativacao['message'] = str_replace("<br />", "", $ativacao['message']);

        return $this->json($ativacao);
    }



    private function pushPlano($contratos)
    {
        $vd_contratos = new VdContrato();

        for ($i = 0; $i < count($contratos); $i++) {
            $contratos[$i]['plano'] = $vd_contratos->when('id', '=', $contratos[$i]['id_vd_contrato'])->filter(['id', 'nome', 'descricao']);
        }

        return $contratos;
    }
}
