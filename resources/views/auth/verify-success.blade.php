@extends('layouts.admin')
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
        <div class="col-12 col-sm-12 col-md-12" style="min-width: 350px;">
            <div class="card border border-light-subtle rounded-3 shadow-sm">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="text-center mb-3">
                        <a href="#!"></a>
                    </div>
                    <div id="message">
                        <div class='alert alert-success'>Berhasil verifikasi</div>
                    </div>
                    <a href="{{url('login')}}" class="btn btn-primary btn-lg">Login Sekarang</a>
                </div>
            </div>
        </div>
    </div>

@endsection
