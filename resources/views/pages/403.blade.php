@extends('layouts.admin')

@php
    $title = 'Akses Ditolak';
    $subtitle = 'Restricted Area';
    $slug = 'error-403';
@endphp

@section('content')
    <div class="row justify-content-center mt-5">
        <div class="col-md-10">
            <div class="card border-0 shadow-sm text-center p-5">
                <div class="card-body">
                    <div class="mb-4">
                        <i class="bi bi-shield-lock-fill text-danger" style="font-size: 5rem;"></i>
                    </div>
                    <h1 class="display-1 fw-bold text-secondary">403</h1>
                    <h2 class="h4 mb-3 text-danger">AKSES DITOLAK</h2>

                    <p class="text-muted mb-4 lead">
                        {{ $exception->getMessage() ?: 'Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.' }}
                    </p>

                    <div class="d-flex justify-content-center gap-2">
                        <a href="{{ url('/') }}" class="btn btn-secondary">
                            <i class="bi bi-house-door me-1"></i> Dashboard
                        </a>
                        <button onclick="history.back()" class="btn btn-primary">
                            <i class="bi bi-arrow-left me-1"></i> Kembali
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
