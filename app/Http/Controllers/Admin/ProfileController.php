<?php

namespace App\Http\Controllers\Admin;

use App\Helper\WhatsAppHelper;
use App\Http\Controllers\Controller;
use App\Models\Kantor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function getIndex()
    {
        $users = User::query()->first() ?? new Kantor;
        $params = [
            'user' => $users,
            'title' => 'Pengaturan User',
        ];
        return view('admin.profile.index', $params);
    }

    public function postSimpanProfile(Request $request)
    {
        $id = $request->input('id');
        if (!$id){
            return errorAlert('ID user tidak boleh kosong');
        }

        $email = strtolower($request->input('email'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            return errorAlert('Email tidak valid');
        }
        $checkEmail = User::query()->where('email', $email)
        ->where('id', '!=', $id)
        ->first();
        if ($checkEmail){
            return errorAlert('Email sudah terdaftar');
        }

        $nama = $request->input('nama');
        if (!$nama){
            return errorAlert('Nama tidak boleh kosong');
        }

        $no_telp = $request->input('no_telp');
        if (!$no_telp){
            return errorAlert('No Telp tidak boleh kosong');
        }
        $nomor_hp = WhatsAppHelper::formatNomorHp($no_telp);
        $formatNomorHp = substr($nomor_hp, 2);

        // Opsional
        $alamat_detail = $request->input('alamat_detail');
        $tanggal_lahir = $request->input('tanggal_lahir');
        $tgl = Carbon::parse($tanggal_lahir);
        if($tgl->greaterThan(Carbon::today())){
            return errorAlert('Tanggal Lahir tidak bisa melebihi hari ini');
        }

        $jenis_kelamin = $request->input('jenis_kelamin');
        $kelurahan_kode = $request->input('kode_lokasi');

        $user = User::findOrFail($id);

        DB::beginTransaction();
        try {

            $user->nama = $nama;
            $user->email = $email;
            $user->no_telp = $formatNomorHp;
            $user->alamat_detail = $alamat_detail;
            $user->tanggal_lahir = $tanggal_lahir;
            $user->jenis_kelamin = $jenis_kelamin;
            $user->kelurahan_kode = $kelurahan_kode;
            $user->save();
            DB::commit();

            return successAlert('Berhasil simpan profile', null, null, '/admin/profile');

        }catch (\Exception $e){
            DB::rollBack();
            return errorAlert($e->getMessage());
        }
    }

    public function postSimpanPassword(Request $request)
    {
        $id = $request->input('id');
        if (!$id){
            return errorAlert('ID user tidak boleh kosong');
        }

        $pass = $request->input('password');
        if(empty($pass)){
            return errorAlert('Password tidak boleh kosong');
        }

        $user = User::findOrFail($id);

        DB::beginTransaction();
        try {

            $user->password = Hash::make($pass);
            $user->save();
            DB::commit();

            return successAlert('Berhasil update password', null, null, '/admin/profile');

        }catch (\Exception $e){
            DB::rollBack();
            return errorAlert($e->getMessage());
        }
    }

    public function postChangePhoto(Request $request)
    {
        $id = $request->input('id');
        if (!$id){
            return errorAlert('ID user tidak boleh kosong');
        }
        $checkId = User::find($id);
        if (!$checkId){
            return errorAlert('ID user tidak ditemukan');
        }
        $params = [
            'user' => $checkId,
        ];
        return view('admin.profile.change-photo', $params);
    }

    public function postSimpanPhoto(Request $request)
    {
        $id = $request->input('id');
        if (!$id){
            return errorAlert('ID user tidak boleh kosong');
        }

        $checkId = User::find($id);
        if (!$checkId){
            return errorAlert('ID user tidak ditemukan');
        }

        $file = $request->file('photo');
        if (!$file){
            return errorAlert('Photo tidak boleh kosong');
        }
        if ($file->isValid()){
            $ext = $file->getClientOriginalExtension();
            if (!in_array($ext, ["jpg", "png", "jpeg"])){
                return errorAlert('Photo tidak valid');
            }
        }

        DB::beginTransaction();
        try {
            if ($checkId->photo){
                Storage::disk('r2')->delete($checkId->photo);
            }
            $file = $file->store('profile', 'r2');
            $checkId->photo = $file;
            $checkId->save();
            DB::commit();
            return successAlert('Berhasil update photo', null, null, '/admin/profile');
        }catch (\Exception $e){
            DB::rollBack();
            return errorAlert($e->getMessage());
        }
    }


}
