@extends('layouts.default')


@section('title', 'Contrato')


@section('content')

    <object data="{{ asset('static/documents/contrato.pdf') }}" type="application/pdf" width="100%" height="100%">

@endsection
