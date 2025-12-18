<?php

namespace App\Jobs;

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
    }
}
