<?php

namespace App\Http\Controllers\Auth;

use App\Helper\TelegramHelper;
use App\Http\Controllers\Controller;
// use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Jobs\SendVerificationEmailRegistration;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function getIndex($id)
    {
        $cek = User::find($id);
        if (! $cek) {
            return errorAlert('Tidak ditemukan');
        }

        if ($cek->email_verified_at) {
            return redirect('/dashboard');
        }
        $params = [
            'user' => $cek,
            'title_body' => 'Verifikasi Email Kamu',
            'body' => 'Kami telah mengirim link verifikasi ke email kamu.',
        ];

        return view('auth.verify-email', $params);
    }

    public function postResend(Request $request)
    {
        $email = $request->input('email');
        if (! $email) {
            return errorAlert('Input Email Tidak ditemukan');
        }
        $user = User::where('email', $email)->first();
        if (! $user) {
            return errorAlert('Email tidak ada di database');
        }
        if ($user->email_verified_at) {
            return errorAlert('Email sudah terverifikasi');
        }
        try {
            dispatch(new SendVerificationEmailRegistration($user));
            TelegramHelper::sendNotification("Berhasil kirim email untuk user baru $user->email");

            return successAlert('Email verifikasi baru berhasil dikirim. Silakan cek inbox/spam.', null, null);
        } catch (\Exception $e) {
            return errorAlert('Terjadi Kesalahan'.$e->getMessage());
        }
    }
}
