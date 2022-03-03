@extends('layouts.sidenav')


@section('title', Auth::user()->name())



@section('alerts')
    <div class="alert-container" data-alert-container-to="fornecedorAlert">
        <div id="fornecedorAlert" class="alert" role="alert">
            <div id="fornecedorAlertBody" class="alert-body text-white"></div>
            <button class="btn-close-widget" data-alert-close="fornecedorAlert">
                <i data-feather="x"></i>
            </button>
        </div>
    </div>
@endsection



@section('modal-content')
    <div id="novoFornecedorModal" class="modal fade" tabindex="-1" aria-labelledby="novoFornecedorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="novoFornecedorModalLabel">Fornecedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="fornecedor-razao"><span class="text-muted fs-3">RAZÃO SOCIAL</span></label>
                            <input type="text" id="fornecedor-razao" class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label for="fornecedor-fantasia"><span class="text-muted fs-3">FANTASIA</span></label>
                            <input type="text" id="fornecedor-fantasia" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-7">
                            <div class="d-flex flex-row justify-content-between">
                                <label for="fornecedor-cnpj_cpf"><span id="label-cnpj_cpf" class="text-muted fs-3">CNPJ</span></label>
                                <div class="d-flex flex-row justify-content-end flex-grow-1">
                                    <label class="form-check-label text-secondary fs-3 me-1" for="fornecedor-icms">Contribuinte ICMS?</label>
                                    <input class="form-check-input" type="checkbox" role="switch" id="fornecedor-icms">
                                </div>
                            </div>
                            <input type="text" id="fornecedor-cnpj_cpf" class="form-control form-control-sm" data-mask="00.000.000/0000-00">
                        </div>
                        <div class="col-5">
                            <label for="btn-group-fornecedor-tipo_pessoa"><span class="text-muted fs-3">TIPO PESSOA</span></label>
                            <div id="btn-group-fornecedor-tipo_pessoa" class="btn-group d-flex flex-row justify-content-between" role="group">

                                <input type="radio" class="btn-check" name="options-fornecedor-tipo_pessoa" id="fornecedor-fisica" autocomplete="off" data-radio="F">
                                <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="fornecedor-fisica"><span class="fs-3">Física</span></label>

                                <input type="radio" class="btn-check" name="options-fornecedor-tipo_pessoa" id="fornecedor-juridica" autocomplete="off" data-radio="J" checked>
                                <label class="btn btn-sm btn-outline-secondary flex-grow-1" for="fornecedor-juridica"><span class="fs-3">Jurídica</span></label>

                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-6">
                            <label for="fornecedor-telefone"><span class="text-muted fs-3">TELEFONE</span></label>
                            <input type="text" id="fornecedor-telefone" class="form-control form-control-sm" data-mask="(00) 9 0000-0000" data-mask-clearifnotmatch="true">
                        </div>
                        <div class="col-6">
                            <label for="fornecedor-celular"><span class="text-muted fs-3">CELULAR</span></label>
                            <input type="text" id="fornecedor-celular" class="form-control form-control-sm" data-mask="(00) 9 0000-0000" data-mask-clearifnotmatch="true">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-9">
                            <label for="fornecedor-endereco"><span class="text-muted fs-3">ENDEREÇO</span></label>
                            <input type="text" id="fornecedor-endereco" class="form-control form-control-sm">
                        </div>
                        <div class="col-3">
                            <label for="fornecedor-endereco"><span class="text-muted fs-3">Nº</span></label>
                            <input type="number" id="fornecedor-endereco" class="form-control form-control-sm">
                        </div>
                    </div>
                    <div class="row gx-1">
                        <div class="col-12">
                            <form class="form-floating">
                                <textarea id="fornecedor-obs" class="form-control" placeholder="Observação" style="height: 100px"></textarea>
                                <label for="fornecedor-obs">Observação</label>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Salvar</button>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('fornecedores', 'active')
@section('page', 'Fornecedores')



@section('subheader-control')
    <div class="btn-toolbar mb-2 mb-md-0">
        <button type="button" class="btn btn-light me-1" data-bs-toggle="collapse" data-bs-target="#collapseFilter" aria-expanded="false" aria-controls="collapseFilter">
            <i data-feather="filter"></i>
        </button>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#novoFornecedorModal">Cadastrar</button>
    </div>
@endsection



@section('content')

    <div class="collapse" id="collapseFilter">
        <div class="card card-body mb-3">
            <div class="row gx-4">
                <div class="col-5">
                    <span class="text-secondary fs-3">Filtrar por:</span>
                    <div class="row gx-1 w-100">
                        <div class="col-2"> <input type="text" id="search-id" class="form-control form-control-sm" placeholder="ID"> </div>
                        <div class="col-3"> <input type="text" id="search-id_ixc" class="form-control form-control-sm" placeholder="IXC"> </div>
                        <div class="col-7"> <input type="text" id="search-cnpj" class="form-control form-control-sm" placeholder="CNPJ"> </div>
                    </div>
                    <div class="row gx-1 w-100 mt-1">
                        <div class="col-7"> <input type="text" id="search-razao" class="form-control form-control-sm" placeholder="Razão"> </div>
                        <div class="col-5"> <input type="text" id="search-fantasia" class="form-control form-control-sm" placeholder="Fantasia"> </div>
                    </div>
                </div>
                <div class="col-3">
                    <span class="text-secondary fs-3">Status:</span>
                    <div class="row gx-1 w-100">
                        <div class="form-check" style="margin-top: -3px;">
                            <input class="form-check-input" type="checkbox" id="search-habilitado" checked>
                            <label class="form-check-label" for="search-sincronizado">Sincronizado</label>
                        </div>
                        <div class="form-check" style="margin-top: -2px;">
                            <input class="form-check-input" type="checkbox" id="search-desabilitado" checked>
                            <label class="form-check-label" for="search-habilitado">Habilitado</label>
                        </div>
                        <div class="form-check" style="margin-top: -2px;">
                            <input class="form-check-input" type="checkbox" id="search-desabilitado" checked>
                            <label class="form-check-label" for="search-desabilitado">Desabilitado</label>
                        </div>
                    </div>
                </div>
                <div class="col-4">
                    <div class="d-flex flex-row justify-content-end align-items-end w-100">
                        <button type="button" class="btn btn-sm btn-outline-secondary me-1">Limpar</button>
                        <button type="button" class="btn btn-sm btn-primary">Aplicar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body ps-0 pe-0 pt-0">
            <table id="fornecedores" class="table table-sm m-0" cellspacing="0" style="width: 100%;">
                <thead>
                    <tr class="bg-light rounded-top">
                        <th class="ps-3 pt-3 pb-2"> <i data-feather="check-square"></i> </th>
                        <th class="ps-3 pt-3 pb-2">IXC</th>
                        <th class="ps-3 pt-3 pb-2">TÍTULO</th>
                        <th class="pe-3 pt-3 pb-2 d-flex justify-content-end">
                            <span class="text-right">AÇÕES</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="border-top">
                </tbody>
            </table>
            <div class="d-flex flex-row justify-content-end align-items-center ps-2 pe-3 pt-3">
                <div class="btn-group" role="group" data-table="fornecedores">
                </div>
            </div>
        </div>
    </div>

@endsection



@section('layout-scripts')
    <script src="{{ asset('js/pages/cadastros/fornecedores.js') }}"></script>
@endsection