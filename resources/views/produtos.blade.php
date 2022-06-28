<link href = {{ asset("bootstrap/css/bootstrap.css") }} rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href = {{ asset("bootstrap/css/sticky-footer-navbar.css") }} rel="stylesheet" />

    <!-- Optional theme -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap-theme.min.css') }}">
@extends('layotus.footer')
@extends('layotus.default')

@section('header')
@section('title','lista de sidebar')

    {{-- @section('sidebar')
        
    @endsection --}}
Lista de produtos


@foreach ($lista as $item)
    {{$item}}
    <br>
    <br>
@endforeach
@endsection
@section('footer')
@endsection
