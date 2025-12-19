<?php

namespace App\Http\Controllers\Auth;

use App\Helper\TelegramHelper;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailForgotPassword;
use App\Models\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function getFormPassword($id, $email)
    {
        $check = User::find($id);
        if (! $check) {
            return errorAlert('Data ID tidak ditemukan');
        }

        $params = [
            'title' => 'Pinjam Buku',
            'data' => $check,
        ];

        return view('auth.form-password', $params);
    }

    public function postSave(Request $request)
    {
        $newPassword = $request->password;
        $idUser = $request->id;

        if (empty($newPassword)) {
            return errorAlert('Password tidak boleh kosong');
        }

        if (empty($idUser)) {
            return errorAlert('Terjadi kesalahan sistem: User ID tidak ditemukan.');
        }

        $data = User::find($idUser);

        if (! $data) {
            return errorAlert('Data user tidak valid.');
        }

        DB::beginTransaction();
        try {
            $data->password = Hash::make($newPassword);
            $data->save();

            DB::commit();

            // Handle Telegram (Pakai Backtick ` biar aman dari karakter aneh)
            // Contoh output: "Budi Santoso" Berhasil ubah password
            $safeName = '`'.$data->nama.'`';
            TelegramHelper::sendNotification("$safeName Berhasil ubah password");

            $redirectUrl = url('login');

            return successAlert('Password berhasil diubah', null, '', $redirectUrl);

        } catch (\Exception $exception) {
            DB::rollBack();

            Log::error('Gagal Ganti Password: '.$exception->getMessage());

            return errorAlert('Gagal menyimpan: '.$exception->getMessage());
        }
    }

    public function postSendEmail(Request $request)
    {
        $email = $request->input('email');
        if (is_null($email)) {
            return errorAlert('Email tidak boleh kosong');
        }

        $data = User::where('email', $email)->first();
        if (! $data) {
            return errorAlert('Email tidak ditemukan');
        }

        try {

            $url = url("auth/forgot-password/form-password/{$data->id}/".sha1($data->email));
            dispatch(new SendEmailForgotPassword($data, $url));
            $redirectUrl = url('/auth/forgot-password/forgot-password-process/'.$data->id);
            TelegramHelper::sendNotification("Berhasil kirim link reset ke email $data->email");

            return successAlert('Link reset password berhasil dikirimkan ke email', null, '', $redirectUrl);

        } catch (\Exception $e) {
            return errorAlert($e->getMessage());
        }
    }

    public function getForgotPasswordProcess($id)
    {
        $data = User::find($id);
        $params = [
            'data' => $data,
            'title_body' => 'Reset Password',
            'body' => 'Kami telah mengirim link reset password ke email kamu.',
        ];

        return view('auth.forgot-password-process', $params);
    }
}
