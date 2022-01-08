<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">


    @section('styles')
        <link rel="stylesheet" href="{{ asset('css/custom/sidenav.css') }}">
    @endsection


    @include('includes.head')


    <body>

        <nav id="sidenav" class="sidenav bg-light border-end d-flex flex-column">

            <nav class="navbar navbar-light p-3">
                <div class="container-fluid">
                    <div class="row align-content-center">
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                            <button class="btn btn-light" onclick="sidenav.toggle()">
                                <span class="text-secondary"><i class="fas fa-times"></i></span>
                            </button>
                        </div>
                        <div class="col-12 col-sm-6 col-md-6 col-lg-6 text-end">
                        </div>
                    </div>
                </div>
            </nav>

            <div class="d-flex flex-column justify-content-center align-items-stretch flex-grow-1 p-3">

                @yield('navcontent')

            </div>

        </nav>

        <div class="container-fluid d-flex flex-column vh-100">
            @yield('content')
        </div>

        @include('includes.scripts')

        <script src="{{ asset('js/sidenav.js') }}"></script>

        @yield('scripts')

    </body>
</html>
