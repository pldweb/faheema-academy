@extends('layouts.web')
@section('content')
    <div class="min-vh-100 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-center py-5">
                        <div class="position-relative">
                            <h1 class="error-title error-text mb-0">404</h1>
                            <h4 class="error-subtitle text-uppercase mb-0">Opps, page not found</h4>
                            <p class="font-size-16 mx-auto text-muted w-50 mt-4">Halaman yang kamu cari ngga ada nih</p>
                        </div>
                        <div class="mt-4 text-center">
                            <a class="btn btn-danger btn-lg" href="{{url()->previous()}}">
                                <i class="bx bx-arrow-back"></i>
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
