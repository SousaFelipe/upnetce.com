@extends('layouts.default')


@section('title', 'Login')


@section('styles')
    <link  href="{{ asset('css/pages/financeiro/auth.css') }}" type="text/css" rel="stylesheet">
@endsection



@section('alerts')
    <div class="alert-container" data-darth-container-to="statusLoginAlert">
        <div id="statusLoginAlert" class="alert danger" role="alert">
            <div id="statusLoginAlertBody" class="alert-body text-white"></div>
            <button class="btn-close-widget" data-darth-close="statusLoginAlert">
                <i class="material-icons-two-tone">close</i>
            </button>
        </div>
    </div>
@endsection


@section('content')
    <main class="form-signin">
        <form id="formSignIn" action="{{ route('financeiro.login') }}" method="POST">
            @csrf

            <img class="mb-4" src="https://getbootstrap.com/docs/5.1/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            <div class="form-floating">
                <input type="email" id="inputEmail" class="form-control" placeholder="name@example.com">
                <label for="floatingInput">Email address</label>
            </div>

            <div class="form-floating">
                <input type="password" id="inputPassword" class="form-control" placeholder="Password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>

            <button type="button" id="btnLogin" class="w-100 btn btn-lg btn-primary" onclick="login()">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>

        </form>
    </main>

@endsection


@section('layout-scripts')
    <script src="{{ asset('js/app/components/Alert.js') }}"></script>
    <script src="{{ asset('js/http/Request.js') }}"></script>
    <script src="{{ asset('js/pages/financeiro/auth.js') }}"></script>
@endsection