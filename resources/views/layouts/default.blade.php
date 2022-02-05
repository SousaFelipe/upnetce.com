<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('includes.head')

    <body class="text-center" style="height: 100vh;">

        @yield('alerts')

        @yield('content')

        @include('includes.scripts')

        @yield('layout-scripts')

    </body>
</html>
