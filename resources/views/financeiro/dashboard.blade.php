@extends('layouts.sidenav')


@section('title', Auth::user()->name())



@section('modal-content')

    <div id="novaReceitaModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="novaReceitaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-scrollable">
            <div class="modal-content rounded-4 shadow">
                <div class="modal-header">
                    <h5 class="modal-title" id="categoriasModalLabel">Receita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row ps-2 pe-2">
                        <div class="col-12 d-flex flex-row align-items-end mb-3">                                
                            <div class="d-flex flex-column flex-grow-1">
                                <select id="receita-categoria" class="form-select">
                                    <option value="0" disabled>Categoria</option>
                                </select>
                            </div>
                            <button class="btn btn-primary ms-1 pt-1 pb-2" data-bs-toggle="modal" data-bs-previous="novaReceitaModal" data-bs-target="#categoriasModal">
                                <span data-feather="plus"></span>
                            </button>
                        </div>
                        <div class="col-12 mb-3">
                            <select id="receita-tipo" class="form-select">
                                <option value="0">Tipo</option>
                                <option value="S">Fixa</option>
                                <option value="N">Variada</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="form-floating">
                                <input type="text" id="receita-descricao" class="form-control form-control-sm" placeholder="Descrição">
                                <label for="receita-descricao">Descrição</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer flex-nowrap p-0">
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0 border-end" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-lg btn-link fs-6 text-decoration-none col-6 m-0 rounded-0">
                        <strong>Salvar</strong>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="novaDespesaModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="novaDespesaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-scrollable">
            <div class="modal-content rounded-4 shadow">
                <header class="modal-header">
                    <div class="d-flex flex-row align-items-center">
                        <div class="bg-orange" style="width: 4px; height: 24px; margin-right: 8px;"></div>
                        <h5 class="header-title mb-0">NOVA DESPESA</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </header>
                <div class="modal-body">
                    <div class="row ps-2 pe-2 pt-1 pb-2">
                        <div class="col-12 mb-2">
                            <div class="row gx-2">
                                <div class="col-5">
                                    <label for="despesa-emissao"><span class="text-muted fs-3">DOCUMENTO</span></label>
                                    <input type="text" id="despesa-documento" class="form-control form-control-sm">
                                </div>
                                <div class="col-7">
                                    <label for="despesa-vencimento"><span class="text-muted fs-3">CÓDIGO DE BARRAS</span></label>
                                    <input type="text" id="despesa-codigo" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row gx-2">
                                <div class="col-9">
                                    <div class="row gx-2">
                                        <div class="col-6">
                                            <label for="despesa-emissao"><span class="text-muted fs-3">EMISSÃO</span></label>
                                            <input type="date" id="despesa-emissao" class="form-control form-control-sm">
                                        </div>
                                        <div class="col-6">
                                            <label for="despesa-vencimento"><span class="text-muted fs-3">VENCIMENTO</span></label>
                                            <input type="date" id="despesa-vencimento" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <label for="btn-group-previsao"><span class="text-muted fs-3">PREVISÃO</span></label>
                                    <div id="btn-group-previsao" class="btn-group d-flex flex-row justify-content-between" role="group">
                                        <input type="radio" class="btn-check" name="options-outlined" id="despesa-previsao-sim" autocomplete="off">
                                        <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="despesa-previsao-sim"><span class="fs-3">SIM</span></label>
                                        <input type="radio" class="btn-check" name="options-outlined" id="despesa-previsao-nao" autocomplete="off" checked>
                                        <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="despesa-previsao-nao"><span class="fs-3">NÃO</span></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div id="finder-despesa-categoria" class="input-group data-finder">
                                <input type="text" id="despesa-categoria-id" class="form-control form-control-sm" placeholder="ID" data-finder="id" style="max-width: 60px;">
                                <select id="despesa-categoria" class="form-select form-select-sm bg-light" data-finder="select"></select>
                                <button type="button" class="btn btn-sm btn-secondary pb-2" data-finder="clear"><i data-feather="x"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary pb-2" data-finder="open"><i data-feather="external-link"></i></button>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div id="finder-despesa-fornecedor" class="input-group data-finder">
                                <input type="text" id="despesa-fornecedor-id" class="form-control form-control-sm" placeholder="ID" data-finder="id" style="max-width: 60px;">
                                <select id="despesa-fornecedor" class="form-select form-select-sm bg-light" data-finder="select"></select>
                                <button type="button" class="btn btn-sm btn-secondary pb-2" data-finder="clear"><i data-feather="x"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary pb-2" data-finder="open"><i data-feather="external-link"></i></button>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <div id="finder-despesa-conta_caixa" class="input-group data-finder">
                                <input type="text" id="despesa-conta_caixa-id" class="form-control form-control-sm" placeholder="ID" data-finder="id" style="max-width: 60px;">
                                <select id="despesa-conta_caixa" class="form-select form-select-sm bg-light" data-finder="select"></select>
                                <button type="button" class="btn btn-sm btn-secondary pb-2" data-finder="clear"><i data-feather="x"></i></button>
                                <button type="button" class="btn btn-sm btn-secondary pb-2" data-finder="open"><i data-feather="external-link"></i></button>
                            </div>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="btn-group-tipo_pagamento"><span class="text-muted fs-3">TIPO DE PAGAMENTO</span></label>
                            <div id="btn-group-tipo_pagamento" class="btn-group d-flex flex-row justify-content-between" role="group">
                                <input type="radio" class="btn-check" name="options-tipo_pagamento" id="despesa-tipo-boleto" autocomplete="off" checked>
                                <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="despesa-tipo-boleto">Boleto</label>

                                <input type="radio" class="btn-check" name="options-tipo_pagamento" id="despesa-tipo-cheque" autocomplete="off">
                                <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="despesa-tipo-cheque">Cheque</label>

                                <input type="radio" class="btn-check" name="options-tipo_pagamento" id="despesa-tipo-cartao" autocomplete="off">
                                <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="despesa-tipo-cartao">Cartão</label>

                                <input type="radio" class="btn-check" name="options-tipo_pagamento" id="despesa-tipo-dinheiro" autocomplete="off">
                                <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="despesa-tipo-dinheiro">Dinheiro</label>

                                <input type="radio" class="btn-check" name="options-tipo_pagamento" id="despesa-tipo-deposito" autocomplete="off">
                                <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="despesa-tipo-deposito">Depósito</label>

                                <input type="radio" class="btn-check" name="options-tipo_pagamento" id="despesa-tipo-transferencia" autocomplete="off">
                                <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="despesa-tipo-transferencia">Transferência</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row gx-2">
                                <div class="col-4">
                                    <label for="despesa-valor"><span class="text-muted fs-3">VALOR</span></label>
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><strong>R$</strong></span>
                                        <input type="text" id="despesa-valor" class="form-control">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <label for="despesa-obs"><span class="text-muted fs-3">OBSERVAÇÃO</span></label>
                                    <input type="text" id="despesa-obs" class="form-control form-control-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary">SALVAR</button>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('dashboard', 'active')
@section('page', 'Dashboard')



@section('subheader-control')
    <div class="btn-toolbar mb-2 mb-md-0">
        <select id="selectPeriodo" class="form-select" onchange="loadDashboardByPeriod()">
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
                    <button class="btn btn-sm btn-default" data-bs-toggle="modal" data-bs-target="#novaReceitaModal">
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
                    <button class="btn btn-sm btn-default" data-bs-toggle="modal" data-bs-target="#novaDespesaModal">
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
                            <span id="despesas-emaberto" class="fs-1 text-secondary wrap-loader" style="max-width: 250px"></span>
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
                            <span id="saldo-atual" class="fs-4 text-primary bold wrap-loader" style="max-width: 250px"></span>
                            <span id="saldo-previsto" class="fs-1 text-secondary wrap-loader" style="max-width: 250px"></span>
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