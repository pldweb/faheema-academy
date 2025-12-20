<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Faheema Academy | {{$title ?? 'dashboard'}}</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="Author" content="Muhammad Rivaldi Fanani">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{favicon_url()}}">
    <link href="{{asset('libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('libs/choices.js/public/assets/styles/choices.min.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('libs/flatpickr/flatpickr.min.css')}}">
    <link href="{{asset('css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/admin.css')}}" type="text/css">

    <script src="{{asset('js/jquery-3.7.1.min.js')}}"></script>
    <script src="{{asset('js/main.js')}}"></script>

</head>
<body>

<div id="layout-wrapper">
    @include('components.top-navbar')
    @include('components.sidebar')
    @include('components.left-sidebar-end')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
</div>

@include('components.modal')

<script src="{{asset('libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('libs/metismenujs/metismenujs.min.js')}}"></script>
<script src="{{asset('libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('libs/eva-icons/eva.min.js')}}"></script>

<script src="{{asset('libs/choices.js/public/assets/scripts/choices.min.js')}}"></script>
<script src="{{asset('libs/flatpickr/flatpickr.min.js')}}"></script>

<script src="{{asset('js/pages/form-advanced.init.js')}}"></script>

<script src="{{asset('libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
<script src="{{asset('libs/jsvectormap/maps/world-merc.js')}}"></script>
<script src="{{asset('js/pages/dashboard.init.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
