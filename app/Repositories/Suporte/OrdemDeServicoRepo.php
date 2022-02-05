<?php
namespace App\Repositories\Suporte;


use App\Models\Suporte\OrdemDeServico;
use App\Repositories\Repository;


class OrdemDeServicoRepo extends Repository
{
    private static $FILTER = [
        'bairro',
        'complemento',
        'data_abertura',
        'data_agenda',
        'data_agenda_final',
        'data_fechamento',
        'data_final',
        'data_hora_encaminhado',
        'data_inicio',
        'endereco',
        'id',
        'id_assunto',
        'id_atendente',
        'id_cidade',
        'id_cliente',
        'id_filial',
        'id_login',
        'id_tecnico',
        'id_ticket',
        'impresso',
        'mensagem',
        'mensagem_resposta',
        'origem_cadastro',
        'origem_endereco',
        'protocolo',
        'referencia',
        'setor',
        'status',
        'tipo',
        'valor_total',
        'valor_total_comissao'
    ];



    public static function queryAbertasByCliente($provedor, $token, $cliente)
    {
        return self::bind(OrdemDeServico::class)
            ->assign($token)
            ->grid([
                'TB' => 'su_oss_chamado.id_cliente',
                'OP' => '=',
                'P'  => $cliente
            ], [
                'TB' => 'su_oss_chamado.status',
                'OP' => '!=',
                'P'  => 'F'
            ])
            ->orderBy('data_abertura', 'asc')
            ->filter(self::$FILTER);
    }
}
