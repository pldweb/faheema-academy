@extends('layouts.web')
@section('title', '')
@section('content')

    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">

                        <div class="mb-4 pb-2">
                            <a href="{{url('')}}" class="d-block auth-logo">
                                <img src="{{logo_utama_url()}}" alt="" height="30" class="auth-logo-dark me-start">
                                <img src="{{logo_utama_url()}}" alt="" height="30" class="auth-logo-light me-start">
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="p-2 my-2 text-center">
                                    <div class="avatar-lg mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="bx bx-mail-send h2 mb-0 text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-1">
                                        <h4>Berhasil Verifikasi !</h4>
                                        <p class="text-muted">Selamat <b>{{$email}}</b> kamu berhasil terverifikasi</p>
                                        <div class="mt-4">
                                            <a href="{{url('/login')}}" class="btn btn-primary w-100">Kembali ke Halaman Login</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
