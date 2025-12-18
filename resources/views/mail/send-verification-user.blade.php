@extends('layouts.mail')
@section('content')
    <div class="container">
        <div class="header">
            <h2>Segera Verifikasi Akun Kamu</h2>
        </div>
        <div class="content">
            <p>Halo, <strong>{{$user->nama}}</strong>!</p>

            <p>Segera verifikasi email kamu dengan klik tombol di bawah</p>

            <p>Hanya Berlaku Selama 5 Menit</p>

            <a href="{{$verifyUrl}}" class="btn ">Verifikasi Sekarang</a>

            <br>
            <p>Salam,<br>Tim Faheema Academy</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}.
        </div>
    </div>
@endsection
