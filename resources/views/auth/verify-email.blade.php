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
        <div class="col-12 col-sm-10 col-md-12">
            <div class="card border border-light-subtle rounded-3 shadow-sm">
                <div class="card-body p-3 p-md-4 p-xl-5">
                    <div class="text-center mb-3">
                        <a href="#!"></a>
                    </div>
                    <h2 class="fs-6 fw-normal text-center text-secondary mb-4">{{$title_body}}</h2>
                    <div id="message">
                        <div class='alert alert-warning'>{{$body}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
