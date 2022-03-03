<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @yield('meta-tags')
    
    <title>UPNET: @yield('title')</title>

    <link
        href="https://fonts.gstatic.com"
        rel="preconnect" >

    <link
        href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp"
        rel="stylesheet">
    
    <link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <link href="{{ asset('css/main.css') }}" type="text/css" rel="stylesheet">
    
    <link href="{{ asset('vendor/datatables/dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/pace/minimal.css') }}" type="text/css" rel="stylesheet">

    @yield('styles')

</head>
