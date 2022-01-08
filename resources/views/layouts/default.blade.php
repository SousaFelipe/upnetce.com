<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('includes.head')

    <body style="height: 100vh;">

        @yield('content')

        @include('includes.scripts')

    </body>
</html>
