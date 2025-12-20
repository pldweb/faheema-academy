@extends('layouts.admin')
@section('title', $title ?? 'Data Kantor')
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="">Data Kantor</h2>
                    <p class="card-title-desc">Ini adalah deskripsinya</p>
                </div>
                <div class="card-body">
                    <form id="form-kantor" enctype="multipart/form-data" onsubmit="return false;">
                        <input type="hidden" name="id" value="{{ $kantor->id ?? '' }}">
                        <div class="mb-3 row">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label">Logo Utama</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="logo" accept="image/*">
                                </div>
                                <div class="col-md-4">
                                    @if($kantor->logo)
                                        <img src="{{ Storage::disk('r2')->url($kantor->logo) }}" alt="Logo" style="max-height: 40px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label">Logo Invert (Putih)</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="logo_invert" accept="image/*">
                                </div>
                                <div class="col-md-4">
                                    @if($kantor->logo_invert)
                                        <div class="px-1 py-1 border rounded bg-dark text-center">
                                            <img src="{{ Storage::disk('r2')->url($kantor->logo_invert) }}" alt="Logo Inv" style="max-height: 37px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Favicon --}}
                        <div class="mb-3 row">
                            <div class="col-md-12 row">
                                <label class="col-md-2 col-form-label">Favicon (Icon Browser)</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" name="favicon" accept="image/*">
                                </div>
                                <div class="col-md-4">
                                    @if($kantor->favicon)
                                        <img src="{{ Storage::disk('r2')->url($kantor->favicon) }}" alt="Fav" style="max-height: 32px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Nama Perusahaan <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="nama_perusahaan" value="{{ $kantor->nama_perusahaan ?? '' }}" required placeholder="Contoh: PT Faheema Tech">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Tagline / Slogan</label>
                            <div class="col-md-10">
                                <input class="form-control" type="text" name="tagline" value="{{ $kantor->tagline ?? '' }}" placeholder="Solusi Digital Masa Depan">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Alamat</label>
                            <div class="col-md-10">
                                <textarea class="form-control" name="alamat_detail" rows="3" placeholder="Jl. Sudirman No. 10...">{{ $kantor->alamat_detail ?? '' }}</textarea>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                            <div class="col-md-10">
                                <select class="form-control" name="kode_lokasi" id="cari-lokasi">
                                    @if($kantor->wilayah)
                                        <option value="{{ $kantor->kelurahan_kode }}" selected>
                                            {{$kantor->wilayah->kode_pos}} {{ $kantor->wilayah->nama }}, {{ $kantor->wilayah->kecamatan->nama ?? '' }}, {{ $kantor->wilayah->kecamatan->kabupaten->nama ?? '' }}
                                        </option>
                                    @else
                                        <option value="">Ketik Kelurahan, Kecamatan, atau Kodepos...</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Email Resmi</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                    <input type="email" class="form-control" name="email" value="{{ $kantor->email ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label class="col-md-2 col-form-label">Nomor Telepon</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                    <input type="text" class="form-control" name="nomor_telepon" value="{{ $kantor->nomor_telepon ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-5 row">
                            <label class="col-md-2 col-form-label">WhatsApp / HP</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <span class="input-group-text">+62</span>
                                    <input type="text" class="form-control" id="no_telp" maxlength="13" name="nomor_handphone" value="{{ $kantor->nomor_handphone ?? '' }}">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary waves-effect waves-light">
                            <i class="bx bx-save font-size-16 align-middle me-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var urlPencarian = '/ajax/lokasi/search';
            initAjaxChoices('cari-lokasi', urlPencarian);

            $("#form-kantor").submit(function (e){
                e.preventDefault()
                let dataInput = new FormData(this)

                confirmModal('Anda yakin ingin simpan informasi perusahaan?', function(){
                    ajxProcess('/admin/kantor/simpan', dataInput, '#message-modal');
                })
            })

            $("#no_telp").on("keypress", function (e) {
                if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                    return false;
                }
            });
        })

    </script>
@endsection
