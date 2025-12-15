@extends('layouts.web')
@section('title', $title)
@section('content')

    <style>
        .content-master {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative;
        }
    </style>

    <div class="row justify-content-center">
        <div class="col-12 col-sm-8">
            <div class="card border border-light-subtle rounded-3 shadow-sm">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="text-center mb-3">
                        <a href="#!"></a>
                    </div>
                    <div id="message"></div>
                    <h2 class="fs-6 fw-normal text-center text-secondary mb-4">Ganti Password</h2>
                    <form method="post" id="form-login" onsubmit="return false;">
                        @csrf
                        <div class="row gy-2 overflow-hidden">
                            <div class="col-12">
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" name="password" id="password" value=""
                                           placeholder="Password" required>
                                    <label for="password" class="form-label">Password</label>
                                </div>
                            </div>
                            <input type="hidden" name="id" class="hidden" value="{{$data->id}}">
                            <div class="col-12">
                                <div class="d-grid my-3">
                                    <button type="submit" class="btn btn-primary btn-lg">Simpan Password Baru</button>
                                </div>
                            </div>
                            <hr>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#form-login').submit(function () {
                let dataInput = new FormData(this);
                console.log(dataInput);
                ajxProcess('/auth/forgot-password/save', dataInput, '#message')
            })
        })
    </script>

@endsection

