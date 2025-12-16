<?php

namespace App\Jobs;

use App\Mail\SendVerificationEmailRegistration as MailSender;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendVerificationEmailRegistration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function handle(): void
    {

        $verifyUrl = url("auth/register/verify-email/{$this->user->id}/".sha1($this->user->email));

        Mail::to($this->user->email)->send(new \App\Mail\SendVerificationUserRegister($verifyUrl, $this->user));

//        Mail::mailer('resend')->send([], [], function ($message) use ($user, $verifyUrl) {
//            $message->to($user->email)
//                ->subject('Verifikasi Email Akun Kamu')
//                ->html("
//            <h2>Halo, {$user->nama}</h2>
//            <p>Terima kasih sudah mendaftar di <b>Pinjam Buku</b>.</p>
//            <p>Klik tombol di bawah ini untuk memverifikasi email kamu:</p>
//            <a href='{$verifyUrl}'
//                style='display:inline-block;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;'>Verifikasi Sekarang</a>
//            <p>Link ini akan kadaluarsa dalam 24 jam.</p>
//        ");
//        });
    }
}
