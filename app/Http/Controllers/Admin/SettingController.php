<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kantor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private function handleUpload($request, $inputName)
    {
        if ($request->hasFile($inputName)) {
            return $request->file($inputName)->store('kantor', 'r2');
        }

        return null;
    }

    public function getIndex()
    {
        $kantors = Kantor::query()->first() ?? new Kantor;
        $params = ['kantor' => $kantors];

        return view('admin.kantor.index', $params);
    }

    public function postSimpan(Request $request)
    {

        $kantor = Kantor::find($request->id) ?? new Kantor;

        DB::beginTransaction();
        try {
            $newLogo = self::handleUpload($request, 'logo');
            $newFavicon = self::handleUpload($request, 'favicon');
            $newLogoInvert = self::handleUpload($request, 'logo_invert');
            $kantor->nama_perusahaan = $request->nama_perusahaan;
            $kantor->kelurahan_kode = $request->kode_lokasi;
            $kantor->alamat_detail = $request->alamat_detail;
            $kantor->kode_pos = $request->kode_pos;
            $kantor->email = $request->email;
            $kantor->tagline = $request->tagline;
            $kantor->nomor_telepon = $request->nomor_telepon;
            $kantor->nomor_handphone = $request->nomor_handphone;
            $kantor->latitude = $request->latitude;
            $kantor->longitude = $request->longitude;
            if ($newLogo) {
                if ($kantor->logo) {
                    Storage::disk('r2')->delete($kantor->logo);
                }
                $kantor->logo = $newLogo;
            }

            if ($newFavicon) {
                if ($kantor->favicon) {
                    Storage::disk('r2')->delete($kantor->favicon);
                }
                $kantor->favicon = $newFavicon;
            }

            if ($newLogoInvert) {
                if ($kantor->logo_invert) {
                    Storage::disk('r2')->delete($kantor->logo_invert);
                }
                $kantor->logo_invert = $newLogoInvert;
            }
            $kantor->save();
            DB::commit();

            $redirectUrl = url('/admin/kantor');

            return successAlert('Data kantor berhasil disimpan!', null, null, $redirectUrl);

        } catch (\Exception $e) {
            DB::rollback();
            if (isset($newLogo)) {
                Storage::disk('r2')->delete($newLogo);
            }
            if (isset($newFavicon)) {
                Storage::disk('r2')->delete($newFavicon);
            }

            return errorAlert('Gagal menyimpan data: '.$e->getMessage());
        }
    }
}
