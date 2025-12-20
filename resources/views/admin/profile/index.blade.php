@extends('layouts.admin')
@section('title', 'Profile')
@section('content')
    <div class="row">
        <div class="col-xxl-9">
            <div class="card">
                <div class="card-body">
                    <!-- Nav tabs -->
                    <ul class="nav nav-pills nav-justified" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="true">
                                <span>Profile</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#password" role="tab" aria-selected="false" tabindex="-1">
                                <span>Password</span>
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#rekening" role="tab" aria-selected="false" tabindex="-1">
                                <span>Rekening</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab content -->
            <div class="tab-content">
                <div class="tab-pane active show" id="profile" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-2">
                                <form id="form-user" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="mb-3 row">
                                        <x-input label="Kode User" type="text" id="disabledTextInput" disabled="true" name="kode_user" value="{{$user->kode_user ?? 'sss'}}"/>
                                    </div>
                                    <div class="mb-3 row">
                                        <x-input label="Role User" name="role_id" disabled="true" value="{{$user->role_id ?? ''}}"/>
                                    </div>
                                    <div class="mb-3 row">
                                        <x-input label="Nama Lengkap" name="nama" placeholder="Masukkan nama" value="{{$user->nama ?? ''}}"/>
                                    </div>
                                    <div class="mb-3 row">
                                        <x-input label="Email" type="email" name="email" value="{{$user->email ?? ''}}"/>
                                    </div>
                                    <div class="mb-3 row">
                                        <x-input-phone label="No Telp" name="no_telp" prefix="+62" value="{{$user->no_telp ?? ''}}" />
                                    </div>
                                    <div class="mb-3 row">
                                        <x-input label="Alamat Detail (Jalan, RT/RW, No. Gedung)" name="alamat_detail" value="{{$user->alamat_detail}}" type="text"/>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Cari Kelurahan / Kecamatan <span class="text-danger">*</span></label>
                                        <select style="padding:0;" class="form-control" name="kode_lokasi" id="cari-lokasi">
                                            @if($user->wilayah)
                                                <option value="{{ $user->kelurahan_kode }}" selected>
                                                    {{$user->wilayah->kode_pos}} {{ $user->wilayah->nama }}, {{ $user->wilayah->kecamatan->nama ?? '' }}, {{ $user->wilayah->kecamatan->kabupaten->nama ?? '' }}
                                                </option>
                                            @else
                                                <option value="">Ketik Kelurahan, Kecamatan, atau Kodepos...</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3 row">
                                        <button type="submit" class="btn btn-primary">Simpan Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="password" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-2">
                                <form id="form-user" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="mb-3 row">
                                        <x-input label="Password" name="role_id"/>
                                    </div>
                                    <div class="mb-3 row">
                                        <button type="submit" class="btn btn-primary">Simpan Profile</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="rekening" role="tabpanel">
                    <div class="card">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-3">
            <div class="card">
                <div class="card-header">
                    <h5>Foto Profile</h5>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var urlPencarian = "{{ url('ajax/lokasi/search') }}";
            initAjaxChoices('cari-lokasi', urlPencarian);


        })
    </script>
@endsection
