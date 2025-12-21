@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center py-4">
                <div>
                    @if(Auth::user() && Auth::user()->hasRole('administrator'))
                        <button onclick="showModal('user/show-create', 'Tambah User Baru')" id="tambahUser" class="btn btn-primary btn-round">Tambah Data User</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-body border-0 shadow mb-4">
                <div class="table-responsive" id="masterData">
                    @include('admin.user.data')
                </div>
            </div>
        </div>
    </div>

@endsection
