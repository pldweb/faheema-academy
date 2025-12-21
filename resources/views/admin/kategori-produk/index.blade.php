@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center py-4">
                <div>
                    <button onclick="showModal('kategori-produk/show-create', 'Tambah Kategori Baru')" id="tambahpenerbit" class="btn btn-primary btn-round">Tambah Data Kategori</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-body border-0 shadow mb-4">
                <div class="table-responsive" id="masterData">
                    @include('admin.kategori-produk.data')
                </div>
            </div>
        </div>
    </div>

@endsection
