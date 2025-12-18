@extends('layouts.web')
@section('title', 'Verifikasi Email')
@section('content')
    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="mb-4 pb-2">
                            <a href="{{url('/')}}" class="d-block auth-logo">
                                <img src="{{logo_utama_url()}}" alt="" height="30" class="auth-logo-dark me-start">
                                <img src="{{logo_utama_url()}}" alt="" height="30" class="auth-logo-light me-start">
                            </a>
                        </div>

                        <div class="card">
                            <div class="card-body p-4">
                                <div class="p-2 my-2 text-center">
                                    <div class="avatar-lg mx-auto">
                                        <div class="avatar-title rounded-circle bg-light">
                                            <i class="bx bxs-envelope h2 mb-0 text-primary"></i>
                                        </div>
                                    </div>

                                    <div class="mt-4 pt-1">
                                        <h4>Verifikasi Email Kamu</h4>
                                        <p>Kami telah mengirimkan link verifikasi ke email <span class="fw-bold">{{$user->email ?? ''}}</span>, Tolong cek segera</p>
                                        <div class="mt-4">
                                            <a target="_blank" href="https://mail.google.com" class="btn btn-danger w-100">Cek Gmail</a>
                                        </div>
                                    </div>
                                    <input type="hidden" id="email" value="{{ $user->email }}">
                                    <div class="mt-4 text-center">
                                        <p class="mb-0">Tidak terima email? <a href="#" id="resend" class="text-primary fw-semibold"> Kirim Lagi </a> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $("#resend").click(function (e) {
                e.preventDefault();
                let email = $("#email").val();

               confirmModal('Kirim lagi?', function () {
                   ajxProcess("/auth/verification/resend", {email: email}, "#message", null)
               })
            })
        })
    </script>
@endsection
