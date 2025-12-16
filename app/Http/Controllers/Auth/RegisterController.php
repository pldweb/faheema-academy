<?php

namespace App\Http\Controllers\Auth;

use App\Helper\TelegramHelper;
use App\Helper\WhatsAppHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function postRegisterAction(Request $request)
    {
        $existingUser = null;
        if (!empty($request->email)) {
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser && $existingUser->email_verified_at) {
                return errorAlert('Email sudah terdaftar dan terverifikasi');
            }
        }

        if (!empty($request->no_telp)) {
            $formatted = WhatsAppHelper::formatNomorHp($request->no_telp);

            $query = User::where('no_telp', $formatted);

            if ($existingUser) {
                $query->where('id', '!=', $existingUser->id);
            }

            if ($query->exists()) {
                return errorAlert('No. Telp sudah terdaftar');
            }
        }


        DB::beginTransaction();
        try {
            $user = $existingUser ?? new User();

            $user->nama = $request->nama;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            if ($request->no_telp) {
                $user->no_telp = $formatted;
            }

            $user->save();

            $role = Role::firstOrCreate([
                'name' => 'anggota',
                'guard_name' => 'web'
            ]);

            $user->assignRole($role);

            if (env('IS_PRODUCTION') == 1) {

                dispatch(new \App\Jobs\SendVerificationEmailRegistration($user));

                DB::commit();

                $redirectURL = url('/verifikasi');
                TelegramHelper::sendNotification("Berhasil kirim email untuk user baru $user->email");

                return successAlert('Daftar akun berhasil. Silakan cek email untuk verifikasi akun sebelum login.', null, '', $redirectURL);
            }

            $existingUser->update(['email_verified_at' => now()]);

            return successAlert('Daftar akun berhasil. Silakan login.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error register: '.$e->getMessage());

            return errorAlert('Terjadi kesalahan saat mendaftar.');
        }
    }

    public function postResendVerification(Request $request)
    {
        try {

            $user = User::find($request->id);
            dispatch(new \App\Jobs\SendVerificationEmailRegistration($user));

            return true;

        } catch (\Exception $e) {
            return false;
        }
    }

    public function getVerifyEmail($id, $hash)
    {
        $user = User::find($id);

        if (! $user) {
            return errorAlert('User tidak ditemukan.');
        }

        if ($hash !== sha1($user->email)) {
            return errorAlert('Kode verifikasi tidak cocok.');
        }

        $user->update(['email_verified_at' => now()]);

        if ($user->email_verified_at) {
            $params = ['title' => 'Verifikasi Email Akun Kamu'];

            return view('auth.verify-success', $params);
        }

        return true;
    }
}
