@extends('layouts.admin')
@section('title', $title ?? 'Data Kantor')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center py-4">
                <div>
                    @if(Auth::user()->hasRole('administrator'))
                        <button onclick="showModal('/admin/role/show-create', 'Tambah Role Baru')" class="btn btn-primary btn-round">
                            <i class="bi bi-plus-lg me-1"></i> Tambah Role
                        </button>
                        <button id="sync" class="btn btn-secondary">Sync Permissions</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-body border-0 shadow mb-4">
                <div class="table-responsive" id="masterData">
                    @include('admin.role.data')
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#sync').on('click', function (){
            confirmModal('Apakah data yang kamu masukkan sudah benar?', function (){
                ajxProcess('/admin/role/sync-permissions', null, '#message-modal' )
            })
        });
    </script>
@endsection
