<?php

namespace App\Http\Controllers\Admin;

use App\Helper\SendLogAktivitasHelper;
use App\Helper\TelegramHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function getIndex()
    {
        $params = [
            'data' => User::all(),
            'title' => 'List Data Master User',
            'subtitle' => 'Seluruh data master user',
            'slug' => 'ini slug',
        ];

        return view('admin.user.index', $params);
    }

    // reload data table
    public function postLoadData()
    {
        $data = User::all();

        return view('admin.user.data', ['data' => $data]);
    }

    // Menampilkan modal
    public function getShowCreate()
    {
        $roles = Role::all();

        return view('admin.user.create', compact('roles'));
    }

    public function postSimpanPassword(Request $request)
    {
        $id = $request->input('id');
        $userId = User::find($id);
        $password = $request->input('password');
        $konfirmasi_password = $request->input('konfirmasi_password');
        if ($password != $konfirmasi_password) {
            return errorAlert('Password Tidak Sesuai');
        }

        if (strlen(strval($password)) < 5) {
            return errorAlert('Password Minimal 5 Karakter');
        }

        $data = ['password' => Hash::make($password)];

        DB::beginTransaction();
        try {
            if ($userId) {
                $userId->update($data);
            }
            DB::commit();

            return successAlert('Berhasil menyimpan password');
        } catch (\Exception $e) {
            DB::rollback();

            return errorAlert($e->getMessage());
        }
    }

    // simpan data user
    public function postSimpanData(Request $request)
    {
        $id = $request->input('id');
        $userId = User::find($id);

        $user = $request->input('nama');
        if (strlen(strval($user)) == 0) {
            return errorAlert('User Tidak Boleh Kosong');
        }

        $email = $request->input('email');
        if (strlen(strval($email)) == 0) {
            return errorAlert('Email Tidak Boleh Kosong');
        }

        $roleName = $request->input('role');
        if (empty($roleName)) {
            return errorAlert('Role User Wajib Dipilih!');
        }

        $data = [
            'nama' => $user,
            'email' => $email,
        ];

        if ($request->input('no_telp')) {
            $no_telp = preg_replace('/[^0-9]/', '', $request->input('no_telp')); // Hanya angka
            if (strlen($no_telp) === 0) {
                return errorAlert('Nomor telepon tidak boleh kosong');
            }
            if (strlen($no_telp) < 10 || strlen($no_telp) > 15) {
                return errorAlert('Format nomor telepon tidak valid');
            }

            $data['no_telp'] = $no_telp;
        }

        if ($request->input('password')) {
            $data['password'] = Hash::make($request->input('password'));
        }

        DB::beginTransaction();
        try {
            if (! $userId) {
                $newUser = User::create($data);
                $msg = "📕📕 *User Baru Sudah Ditambahkan* 📕📕\n\n";
                $msg .= "Nama User: *{$user}*\n";
                $new = true;
                $newUser->syncRoles($roleName);
                TelegramHelper::sendNotification($msg, 'Markdown');
                SendLogAktivitasHelper::sendLogAktivitas("User baru dengan nama $user ditambahkan oleh");
            } else {
                $userId->update($data);
                $userId->syncRoles($roleName);
                $msg = "📕📕 *User Berhasil Diupdate* 📕📕\n\n";
                $msg .= "Nama: *{$user}*\nRole Baru: _{$roleName}_";
                $new = false;
                TelegramHelper::sendNotification($msg, 'Markdown');
                SendLogAktivitasHelper::sendLogAktivitas("User dengan nama $user diupdate oleh");
            }
            DB::commit();
            if ($new) {
                return successAlert('User Berhasil ditambahkan ', '/user/load-data');
            } else {
                return successAlert('User Berhasil diupdate ', '/user/load-data');
            }

        } catch (\Exception $exception) {
            DB::rollBack();

            return errorAlert('User gagal ditambahkan'.$exception->getMessage());
        }
    }

    public function postEditData(Request $request)
    {
        $id = $request->input('id');
        $check = User::find($id);
        if ($check == null) {
            return errorAlert('Tidak ada data dengan ID ini');
        }
        $roles = Role::all();
        $params = [
            'roles' => $roles,
            'data' => $check,
        ];

        return view('admin.user.edit', $params);
    }

    public function postEditPassword(Request $request)
    {
        $id = $request->input('id');
        $check = User::find($id);
        if ($check == null) {
            return errorAlert('Tidak ada data dengan ID ini');
        }

        return view('admin.user.edit-password', ['data' => $check]);
    }

    public function postDeleteData(Request $request)
    {
        $id = $request->input('id');
        $user = User::find($id);
        if ($user == null) {
            return errorAlert('Tidak ada data dengan ID ini');
        } else {
            $msg = "📕📕 *User dihapus* 📕📕\n\n";
            $msg .= "Judul User: *{$user->judul_user}*\n";
            $msg .= "User: _{$user->user}_\n";
            $msg .= "Stock: _{$user->stock}_";
            TelegramHelper::sendNotification($msg, 'Markdown');
            SendLogAktivitasHelper::sendLogAktivitas("User dengan nama $user->nama dihapus oleh");
            $user->delete();

            return successAlert('Berhasil hapus data', '/user/load-data');
        }
    }
}
