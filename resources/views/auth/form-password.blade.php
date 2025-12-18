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
                                        <h4>Ganti Password Baru Kamu</h4>
                                        <p>Segera ganti password kamu dengan yang baru secepatnya</p>

                                        {{-- TAMBAHAN: Hidden Input buat nyimpen ID User --}}
                                        {{-- $data dikirim dari Controller getFormPassword --}}
                                        <input type="hidden" id="user-id" value="{{ $data->id }}">

                                        <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                            <span class="bx bx-lock-alt"></span>
                                            <input type="password" name="password" class="form-control" id="password-input" placeholder="Enter password">
                                            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                            </button>
                                        </div>
                                        <div class="mt-2"></div>
                                        <a id="resend" href="#" class="btn btn-primary w-100 waves-effect waves-light">Simpan Perubahan</a>
                                    </div>
                                    <div class="mt-4 text-center"></div>
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

                // Ambil nilai Password
                let password = $("#password-input").val();
                // Ambil nilai ID User
                let userId = $("#user-id").val();

                // Debugging: Cek di console browser (Klik kanan -> Inspect -> Console)
                console.log("Password:", password);
                console.log("User ID:", userId);

                if(!password) {
                    alert("Password tolong diisi dulu ya!");
                    return;
                }

                confirmModal('Kirim lagi?', function () {
                    // PERBAIKAN PENTING DI SINI:
                    // Kita kirim object berisi 'password' DAN 'id'
                    let dataKirim = {
                        password: password,
                        id: userId
                    };

                    ajxProcess("/auth/forgot-password/save", dataKirim, "#message-modal", null)
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
        })
    </script>
@endsection
