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
                                        <x-input label="Kode User" type="text" id="disabledTextInput" disabled="true" name="kode_user" value="{{$user->kode_user ?? ''}}"/>
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
                                        <label class="form-label">Jenis Kelamin</label>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input jk" name="jenis_kelamin" value="L" type="checkbox" id="formCheck2" {{$user->jenis_kelamin == 'L' ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="formCheck2">
                                                        Laki-laki
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-check">
                                                    <input class="form-check-input jk" name="jenis_kelamin" value="P" type="checkbox" id="formCheck2" {{$user->jenis_kelamin == 'P' ? 'checked' : ''}}>
                                                    <label class="form-check-label" for="formCheck2">
                                                        Perempuan
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label for="Tanggal Lahir">Tanggal Lahir</label>
                                        <input class="form-control flatpickr-input flatpickr-mobile" value="{{$user->tanggal_lahir}}" name="tanggal_lahir" tabindex="1" type="date" placeholder="">
                                    </div>
                                    <div class="mb-3 row">
                                        <x-input label="Alamat Detail (Jalan, RT/RW, No. Gedung)" name="alamat_detail" value="{{$user->alamat_detail}}" type="text"/>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="form-label">Cari Kelurahan / Kecamatan</label>
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
                                    <input type="hidden" value="{{$user->id}}" name="id">
                                    <div class="mb-3 row">
                                        <button type="submit" class="btn btn-primary">Simpan Profile</button>
                                    </div>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        $("#form-user").submit(function(e) {
                                            e.preventDefault();
                                            let data = new FormData(this);
                                            confirmModal('Apakah data user sudah benar?', function() {
                                                ajxProcess('/admin/profile/simpan-profile', data, "#message-modal")
                                            })
                                        })

                                        $("#no_telp").on("keypress", function (e) {
                                            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                                                return false;
                                            }
                                        });
                                    })
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="password" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-2">
                                <form id="form-password" enctype="multipart/form-data" onsubmit="return false;">
                                    <div class="mb-3">
                                        <label class="form-label" for="password-input">Password</label>
                                        <div class="position-relative auth-pass-inputgroup input-custom-icon">
                                            <span class="bx bx-lock-alt"></span>
                                            <input type="password" class="form-control" name="password" id="password-input" placeholder="Tulis password">
                                            <button type="button" class="btn btn-link position-absolute h-100 end-0 top-0" id="password-addon">
                                                <i class="mdi mdi-eye-outline font-size-18 text-muted"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" value="{{$user->id}}" name="id">
                                    <div class="mb-3 row">
                                        <button type="submit" class="btn btn-primary">Simpan Password</button>
                                    </div>
                                </form>
                                <script>
                                    $(document).ready(function() {
                                        $("#form-password").submit(function(e) {
                                            e.preventDefault();
                                            let data = new FormData(this);
                                            confirmModal('Apakah password sudah benar?', function() {
                                                ajxProcess('/admin/profile/simpan-password', data, "#message-modal")
                                            })
                                        })
                                    })
                                </script>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane" id="rekening" role="tabpanel">
                    <div class="card">
                        <div class="card-body">
                            <p>Sedang pengembangan</p>
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
                    <div class="position-relative text-center border-bottom pb-3">
                        <img src="{{img_url($user->photo)}}" alt="" class="avatar-xl rounded-circle img-thumbnail">
                        <div class="mt-3">
                            <a href="#" class="btn btn-sm btn-primary" onclick="editData({{$user->id}}, '/admin/profile/change-photo', 'Ganti poto profile')">Ganti Foto</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var urlPencarian = "{{ url('ajax/lokasi/search') }}";
            initAjaxChoices('cari-lokasi', urlPencarian);
        })

        $(document).on('change', '.jk', function() {
            $('.jk').not(this).prop('checked', false);
        });
    </script>
@endsection
