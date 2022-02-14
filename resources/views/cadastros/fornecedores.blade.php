@extends('layouts.sidenav')


@section('title', Auth::user()->name())



@section('modal-content')

@endsection



@section('fornecedores', 'active')
@section('page', 'Fornecedores')



@section('subheader-control')
    <div class="btn-toolbar mb-2 mb-md-0">
        
    </div>
@endsection



@section('content')

    <table id="fornecedores" class="table table-striped table-hover" style="width: 100%;">
        <thead>
            <tr>
                <th>RAZAO</th>
                <th>TÍTULO</th>
                <th>ENDEREÇO</th>
                <th>CIDADE</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>

@endsection



@section('layout-scripts')
    <script src="{{ asset('js/app/components/Alert.js') }}"></script>
    <script src="{{ asset('js/pages/financeiro/dashboard.js') }}"></script>
@endsection