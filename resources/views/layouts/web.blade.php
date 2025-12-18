<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Faheema Academy</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="Author" content="Muhammad Rivaldi Fanani">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{favicon_url()}}">

{{--    <link href="{{asset('libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />--}}
    <link href="{{asset('css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/web.css')}}">

    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

</head>
<body>
<div class="content-wrapp">
    @yield('content')
</div>

@include('components.modal')

<script src="{{asset('libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('libs/metismenujs/metismenujs.min.js')}}"></script>
<script src="{{asset('libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('libs/eva-icons/eva.min.js')}}"></script>

<!-- apexcharts -->
{{--<script src="{{asset('libs/apexcharts/apexcharts.min.js')}}"></script>--}}

{{--<script src="{{asset('libs/jsvectormap/js/jsvectormap.min.js')}}"></script>--}}
{{--<script src="{{asset('libs/jsvectormap/maps/world-merc.js')}}"></script>--}}
{{--<script src="{{asset('js/pages/dashboard.init.js')}}"></script>--}}
{{--<script src="{{asset('js/app.js')}}"></script>--}}
</body>
</html>
