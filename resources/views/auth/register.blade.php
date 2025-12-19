@extends('layouts.web')
@section('title', $title)
@section('content')

    <div class="authentication-bg min-vh-100">
        <div class="bg-overlay bg-light"></div>
        <div class="container">
            <div class="d-flex flex-column min-vh-100 px-3 pt-4">
                <div class="row justify-content-center my-auto">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="mb-4 pb-2">
                            <a href="{{url('/')}}" class="d-block auth-logo">
                                <img src="{{img_url('images/kantor/logo_utama.png')}}" alt="" height="30"
                                     class="auth-logo-dark me-start">
                                <img src="{{img_url('images/kantor/logo_utama.png')}}" alt="" height="30"
                                     class="auth-logo-light me-start">
                            </a>
                        </div>
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5>Selamat Datang !</h5>
                                    <p class="text-muted">Daftar akun Faheema Academy.</p>
                                </div>
                                <div id="message"></div>
                                <div class="p-2 mt-4">
                                    <form id="form-register" onsubmit="return false;">
                                        <div class="mb-3">
                                            <label class="form-label" for="nama">Nama</label>
                                            <div class="position-relative input-custom-icon">
                                                <input type="text" class="form-control" name="nama" id="nama" placeholder="Tulis nama">
                                                <span class="bx bx-user"></span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <div class="position-relative input-custom-icon">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="Tulis email">
                                                <span class="bx bx-mail-send"></span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="email">Nomor Handphone</label>
                                            <div class="position-relative input-custom-icon">
                                                <input type="tel" class="form-control" pattern="[0-9]*" inputmode="numeric" maxlength="14" name="no_telp" id="no_telp" placeholder="Tulis nomor handphone">
                                                <span class="bx bx-phone"></span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="{{url('reset-password')}}" class="text-muted text-decoration-underline">Lupa password?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                                <span class="bx bx-lock-alt"></span>
                                                <input type="password" class="form-control" name="password" id="password-input" placeholder="Tulis password">
                                                <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                    <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                                </button>
                                            </div>
                                        </div>
{{--                                        <div class="form-check py-1">--}}
{{--                                            <input type="checkbox" class="form-check-input" id="auth-remember-check">--}}
{{--                                            <label class="form-check-label" for="auth-remember-check">Ingat Saya</label>--}}
{{--                                        </div>--}}
                                        <div class="mt-3">
                                            <button class="btn btn-primary w-100 waves-effect waves-light"
                                                    type="submit">Daftar Sekarang
                                            </button>
                                        </div>
                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Sudah Punya Akun ?
                                                <a href="{{url('login')}}" class="fw-medium text-primary"> Yuk Login Sekarang </a>
                                            </p>
                                        </div>
                                    </form>
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
            $('#form-register').submit(function () {
                const formData = new FormData(this);
                ajxProcess("/auth/register/register-action", formData, "#message");
            })
        })

        $("#password-addon").on('click', function () {
            let input = $("#password-input");
            let type = input.attr('type');
            const icon = $(this).find('i');


            if(type == 'password'){
                input.attr('type', 'text');
                icon.removeClass('mdi-eye-outline').addClass('mdi-eye-off');
            } else {
                input.attr('type', 'password');
                icon.removeClass('mdi-eye-off').addClass('mdi-eye-outline');
            }
        })

        $("#no_telp").on("keypress", function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

    </script>

@endsection

