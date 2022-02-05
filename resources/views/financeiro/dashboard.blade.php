@extends('layouts.sidenav')


@section('title', Auth::user()->name())



@section('modal-content')
    <div id="novaReceitaModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="novaReceitaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoriasModalLabel">Nova Receita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row ps-2 pe-2">
                        <div class="col-7 d-flex flex-row align-items-end mb-3">                                
                            <div class="d-flex flex-column flex-grow-1">
                                <label for="receita-categoria" class="form-label">Categoria</label>
                                <select id="receita-categoria" class="form-select">
                                    <option value="0">Selecionar</option>
                                </select>
                            </div>
                            <button class="btn btn-primary ms-1 pt-1 pb-2" data-bs-toggle="modal" data-bs-previous="novaReceitaModal" data-bs-target="#categoriasModal">
                                <span data-feather="plus"></span>
                            </button>
                        </div>
                        <div class="col-5 mb-3">                                
                            <label for="receita-tipo" class="form-label">Tipo</label>
                            <select id="receita-tipo" class="form-select">
                                <option value="0">Selecionar</option>
                                <option value="S">Fixa</option>
                                <option value="N">Variada</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label for="receita-descricao" class="form-label">Descrição</label>
                            <input type="email" id="receita-descricao" class="form-control" placeholder="Descrição...">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary">Salvar e Sair</button>
                    <button type="button" class="btn btn-success">Salvar</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('dashboard', 'active')
@section('page', 'Dashboard')



@section('subheader-control')
    <div class="btn-toolbar mb-2 mb-md-0">
        <select id="selectPeriodo" class="form-select" onchange="loadReceitasIXC()">
            <option value="January"> Janeiro </option>
            <option value="February"> Fevereiro </option>
            <option value="March"> Março </option>
            <option value="April"> Abril </option>
            <option value="May"> Maio </option>
            <option value="June"> Junho </option>
            <option value="July"> Julho </option>
            <option value="August"> Agosto </option>
            <option value="September"> Setembro </option>
            <option value="October"> Outubro </option>
            <option value="November"> Novembro </option>
            <option value="December"> Dezembro </option>
        </select>
    </div>
@endsection



@section('content')

    <div class="row">

        <div class="col-sm-12 col-md-12 col-lg-4 pt-3">
            <div class="card text-dark bg-light">
                <span class="d-flex flex-row justify-content-end position-absolute w-100">
                    <button class="btn btn-sm btn-default" onclick="novaReceitaModal.show()">
                        <span data-feather="plus-circle"></span>
                    </button>
                </span>
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center">
                        <span class="circle-lg bg-green">
                            <span data-feather="trending-up"></span>
                        </span>
                        <div class="d-flex flex-column justify-content-center flex-grow-1 ms-3 me-sm-0 me-md-4 me-lg-3">
                            <span id="receitas-recebidas-titulo" class="fs-3 text-tertiary wrap-loader" style="max-width: 140px"></span>
                            <span id="receitas-recebidas" class="fs-4 text-primary bold wrap-loader" style="max-width: 250px"></span>
                            <span id="receitas-areceber" class="fs-1 text-secondary wrap-loader" style="max-width: 250px"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-4 pt-3">
            <div class="card text-dark bg-light">
                <span class="d-flex flex-row justify-content-end position-absolute w-100">
                    <button class="btn btn-sm btn-default">
                        <span data-feather="plus-circle"></span>
                    </button>
                </span>
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center">
                        <span class="circle-lg bg-orange">
                            <span data-feather="trending-down"></span>
                        </span>
                        <div class="d-flex flex-column justify-content-center flex-grow-1 ms-3 me-sm-0 me-md-4 me-lg-3">
                            <span id="despesas-pagas-titulo" class="fs-3 text-tertiary wrap-loader" style="max-width: 140px"></span>
                            <span id="despesas-pagas" class="fs-4 text-primary bold wrap-loader" style="max-width: 250px"></span>
                            <span id="despesas-agendadas" class="fs-2 text-secondary wrap-loader" style="max-width: 250px"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-4 pt-3">
            <div class="card text-dark bg-light">
                <div class="card-body">
                    <div class="d-flex flex-row align-items-center">
                        <span class="circle-lg bg-cyan">
                            <span data-feather="bar-chart-2"></span>
                        </span>
                        <div class="d-flex flex-column justify-content-center flex-grow-1 ms-3 me-sm-0 me-md-4 me-lg-3">
                            <span id="saldo-titulo" class="fs-3 text-tertiary wrap-loader" style="max-width: 140px"></span>
                            <span id="saldo" class="fs-4 text-primary bold wrap-loader" style="max-width: 250px"></span>
                            <span id="saldo-previsto" class="fs-2 text-secondary wrap-loader" style="max-width: 250px"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card bg-light mt-4">
                <div class="card-body pt-3 pb-2">
                    <canvas id="balanceChart" class="w-100" height="310"></canvas>
                </div>
            </div>
        </div>

    </div>

@endsection



@section('layout-scripts')
    <script src="{{ asset('js/app/components/Alert.js') }}"></script>
    <script src="{{ asset('js/pages/financeiro/dashboard.js') }}"></script>
@endsection