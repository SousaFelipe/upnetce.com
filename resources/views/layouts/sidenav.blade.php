<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/layouts/sidenav.css') }}">
    @endsection


    @section('meta-tags')
        <meta name="provedor-id" content="{{ Auth::user()->provedor }}">
        <meta name="user-id" content="{{ Auth::user()->id }}" />
    @endsection


    @include('includes.head')


    <body>

        @yield('modal-content')

        <div id="categoriasModal" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="categoriasModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="categoriasModalLabel">Nova Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row ps-2 pe-2">
                            <div class="col-5 mb-3">                                
                                <div class="d-flex flex-row justify-content-between">
                                    <label for="tipo-categoria" class="form-label">Tipo</label>
                                    <div class="form-check form-switch">
                                        <label class="form-check-label" for="categoria-fixa">Fixa?</label>
                                        <input type="checkbox" id="categoria-fixa" class="form-check-input" role="switch">
                                    </div>
                                </div>
                                <select id="tipo-categoria" name="tipo-categoria" class="form-select">
                                    <option value="0">Selecionar</option>
                                    <option value="R">Receita</option>
                                    <option value="D">Despesa</option>
                                </select>
                            </div>
                            <div class="col-7 mb-3">                                
                                <label for="sob-categoria" class="form-label">Sob-categoria</label>
                                <select id="sob-categoria" name="sob-categoria" class="form-select">
                                    <option class="text-tertiary" value="0">Nenhuma...</option>
                                </select>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="titulo-categoria" class="form-label">Título</label>
                                <input type="email" id="titulo-categoria" class="form-control" placeholder="Nome da categoria">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="salvarCategoria(true)">Salvar e Sair</button>
                        <button type="button" class="btn btn-primary" onclick="salvarCategoria(false)">Salvar</button>
                    </div>
                </div>
            </div>
        </div>

        <header class="d-flex flex-row justify-content-between align-items-center sticky-top bg-dark shadow">
            <a class="navbar-brand text-white" href="/financeiro/dashboard">
                <strong>Darth</strong> <small>&#x276F;</small> {{ Auth::user()->name() }}
            </a>
            <div class="navbar-search-control flex-grow-1">
                <input type="text" id="search-control" class="search-control" placeholder="Nome ou CPF do (a) cliente..." aria-label="Nome ou CPF do (a) cliente...">
                <button type="button" class="btn btn-default btn-sm text-white mb-1" onclick="closeSearch()">
                    <i data-feather="x"></i>
                </button>
            </div>
            <div class="navbar-nav">
                <div class="nav-item text-nowrap">
                    <span class="nav-link text-white px-3" onclick="logout()" style="cursor: pointer;">
                        Sair &nbsp; <span data-feather="log-out"></span>
                    </span>
                </div>
            </div>
        </header>

        <div id="search-container" class="container-fluid">
            <div class="row justify-content-center">
                <div id="search-result-items" class="col-sm-12 col-md-12 col-lg-12 col-xl-10">
                    
                </div>
            </div>
        </div>

        <div id="wrap" class="container-fluid">
            <div class="row justify-content-center">

                <nav id="sidebarMenu" class="d-md-block bg-light sidebar collapse">
                    <div class="position-sticky pt-3">
            
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link @yield('dashboard', '')" aria-current="page" href="/financeiro/dashboard">
                                    <span data-feather="home"></span> Dashboard
                                </a>
                            </li>
                            <li class="nav-item @yield('planilhas', '')">
                                <a class="nav-link" href="/financeiro/planilhas">
                                    <span data-feather="file-text"></span> Planilhas
                                </a>
                            </li>
                            <li class="nav-item @yield('receitas', '')">
                                <a class="nav-link" href="/financeiro/receitas">
                                    <span data-feather="trending-up"></span> Receitas
                                </a>
                            </li>
                            <li class="nav-item @yield('despesas', '')">
                                <a class="nav-link" href="/financeiro/despesas">
                                    <span data-feather="trending-down"></span> Despesas
                                </a>
                            </li>
                        </ul>
            
                        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                            <span>Categorias</span>
                            <span class="link-secondary clickable" aria-label="Nova Categoria" data-bs-toggle="modal" data-bs-target="#categoriasModal">
                                <span data-feather="plus-circle"></span>
                            </span>
                        </h6>
            
                        <ul id="categorias-nav-container" class="nav flex-column ps-3 pt-2 pe-3">
                        </ul>
                    </div>
            
                </nav>

                <main class="col-sm-12 col-md-12 col-lg-12 col-xl-10">

                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                        <h1 class="h2">@yield('page')</h1>
                        
                        @yield('subheader-control')

                    </div>

                    @yield('content')

                </main>

            </div>
        </div>

        <form id="logOutForm" action="{{ route('financeiro.logout') }}" method="POST">
            @csrf
        </form>

        @include('includes.scripts')

        <script src="{{ asset('js/http/Request.js') }}"></script>
        <script src="{{ asset('js/app/contents/Flex.js') }}"></script>
        <script src="{{ asset('js/app/components/nav/Item.js') }}"></script>
        <script src="{{ asset('js/app/components/grid/Row.js') }}"></script>
        <script src="{{ asset('js/app/components/grid/Column.js') }}"></script>
        <script src="{{ asset('js/app/components/Card.js') }}"></script>
        <script src="{{ asset('js/app/components/Circle.js') }}"></script>
        <script src="{{ asset('js/app/components/Collapse.js') }}"></script>
        <script src="{{ asset('js/app/components/Link.js') }}"></script>
        <script src="{{ asset('js/app/components/Option.js') }}"></script>
        <script src="{{ asset('js/app/components/Span.js') }}"></script>
        <script src="{{ asset('js/app/components/Text.js') }}"></script>
        
        <script src="{{ asset('js/layout/sidenav.js') }}"></script>

        @yield('layout-scripts')

    </body>
</html>
