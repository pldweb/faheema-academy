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
                                        <h4>Inputkan Email Kamu</h4>
                                        <p>Tulis email kamu untuk dikirimkan link reset password dengan waktu terbatas</p>
                                        <div class="position-relative input-custom-icon">
                                            <input type="email" class="form-control" id="email" name="email" required>
                                            <span class="bx bx-mail-send"></span>
                                        </div>
                                            <div class="mt-4 mb-2">
                                            <a href="#" id="resend" class="btn btn-primary w-100">Kirim Email</a>
                                        </div>
                                        <a class="btn w-100 btn-secondary" href="{{url()->previous()}}" id="resend">Kembali</a>
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
               confirmModal('Kirim Link Reset Password', function () {
                   ajxProcess("/auth/forgot-password/send-email", {email: email}, "#message-modal", null)
               })
            })
        })
    </script>
@endsection
