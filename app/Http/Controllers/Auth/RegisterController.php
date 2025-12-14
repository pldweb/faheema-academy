<?php

namespace App\Http\Controllers\Auth;

use App\Helper\TelegramHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function postRegisterAction(Request $request)
    {
        DB::beginTransaction();
        try {

            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $role = Role::firstOrCreate(['name' => 'anggota', 'guard_name' => 'web']);
            $user->assignRole($role);

            if (env('IS_PRODUCTION') == 1) {

                $verifyUrl = url("auth/register/verify-email/{$user->id}/".sha1($user->email));

                Mail::mailer('resend')->send([], [], function ($message) use ($user, $verifyUrl) {
                    $message->to($user->email)
                        ->subject('Verifikasi Email Akun Kamu')
                        ->html("
            <h2>Halo, {$user->nama}</h2>
            <p>Terima kasih sudah mendaftar di <b>Pinjam Buku</b>.</p>
            <p>Klik tombol di bawah ini untuk memverifikasi email kamu:</p>
            <a href='{$verifyUrl}'
                style='display:inline-block;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;'>Verifikasi Sekarang</a>
            <p>Link ini akan kadaluarsa dalam 24 jam.</p>
        ");
                });

                DB::commit();

                $redirectURL = url('/verifikasi');
                TelegramHelper::sendNotification("Berhasil kirim email untuk user baru $user->email");

                return successAlert('Daftar akun berhasil. Silakan cek email untuk verifikasi akun sebelum login.', null, '', $redirectURL);
            }

            $user->update(['email_verified_at' => now()]);

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
            $verifyUrl = url("auth/register/verify-email/{$user->id}/".sha1($user->email));
            Mail::mailer('resend')->send([], [], function ($message) use ($user, $verifyUrl) {
                $message->to($user->email)
                    ->subject('Verifikasi Email Akun Kamu')
                    ->html("
                    <h2>Halo, {$user->nama}</h2>
                    <p>Terima kasih sudah mendaftar di <b>Pinjam Buku</b>.</p>
                    <p>Klik tombol di bawah ini untuk memverifikasi email kamu:</p>
                    <a href='{$verifyUrl}'
                        style='display:inline-block;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;'>Verifikasi Sekarang</a>
                    <p>Link ini akan kadaluarsa dalam 24 jam.</p>
                ");
            });

            return '';

        } catch (\Exception $e) {
            return '';
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

        return '';
    }
}
