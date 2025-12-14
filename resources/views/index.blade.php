<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Dashboard | Faheema Academy</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{favicon_url()}}">

    <!-- plugin css -->
    <link href="{{asset('libs/jsvectormap/css/jsvectormap.min.css')}}" rel="stylesheet" type="text/css" />

    <!-- Bootstrap Css -->
    <link href="{{asset('css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{asset('css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

</head>
<body>


<div id="layout-wrapper">
    @include('components.top-navbar')
    @include('components.sidebar')
    @include('components.left-sidebar-end')

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">


            </div>
        </div>
    </div>
</div>

{{--@include('components.right-bar')--}}

{{--<!-- chat offcanvas -->--}}
{{--<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasActivity" aria-labelledby="offcanvasActivityLabel">--}}
{{--    <div class="offcanvas-header border-bottom">--}}
{{--        <h5 id="offcanvasActivityLabel">Offcanvas right</h5>--}}
{{--        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>--}}
{{--    </div>--}}
{{--    <div class="offcanvas-body">--}}
{{--        ...--}}
{{--    </div>--}}
{{--</div>--}}

<!-- JAVASCRIPT -->
<script src="{{asset('libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('libs/metismenujs/metismenujs.min.js')}}"></script>
<script src="{{asset('libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('libs/eva-icons/eva.min.js')}}"></script>

<!-- apexcharts -->
<script src="{{asset('libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- Vector map-->
<script src="{{asset('libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
<script src="{{asset('libs/jsvectormap/maps/world-merc.js')}}"></script>
<script src="{{asset('js/pages/dashboard.init.js')}}"></script>
<script src="{{asset('js/app.js')}}"></script>
</body>
</html>
