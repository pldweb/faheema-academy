@extends('layouts.admin')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-start flex-wrap flex-md-nowrap align-items-center py-4">
                <div>
                    {{--                    <button onclick="exportExcel()" class="btn btn-success btn-round text-white"><i class="bi bi-file-earmark-spreadsheet mr-1"></i>Export to Excel</button>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-body border-0 shadow mb-4">
                <div class="table-responsive" id="masterData">
                    @include('admin.log-aktivitas.data')
                </div>
            </div>
        </div>
    </div>

@endsection
