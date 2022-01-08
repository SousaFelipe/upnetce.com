<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    @include('includes.head')

    <body>

        @yield('content')

        @include('includes.scripts')

    </body>
</html>
