<?php
namespace App\Console\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Repositories\Financeiro\ReceitaRepo;


class ResumoCron extends Command
{
    protected $signature = 'receitas_resumo:baixar';
    protected $description = 'Command description';

    
    
    public function __construct()
    {
        parent::__construct();
    }

    
    
    public function handle()
    {
        if (($user = Auth::user()) != null) {

            $now = Carbon::now()->format('F');
            $start = Carbon::parse('1 ' . $now)->toDateString();
            $final = Carbon::parse($now)->endOfMonth()->toDateString();

            $receitas = ReceitaRepo::query($user, $start, $final);

            $totalAberto = array_reduce($receitas['areceber'], function ($carry, $item) {
                return $carry + $item->valor_aberto;
            });

            $totalRecebido = array_reduce($receitas['valor_recebido'], function ($carry, $item) {
                return $carry + $item->valor_aberto;
            });
        }

        return 0;
    }
}
