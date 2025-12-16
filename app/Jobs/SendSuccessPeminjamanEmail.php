<?php

namespace App\Jobs;

use App\Mail\MailSendSuccessPeminjaman;
use App\Models\Peminjaman;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSuccessPeminjamanEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $peminjamanId;

    public function __construct($peminjamanId)
    {
        $this->peminjamanId = $peminjamanId;
    }

    public function handle(): void
    {
        $peminjaman = Peminjaman::with('user')->find($this->peminjamanId);

        Mail::to($peminjaman->user->email)->send(new MailSendSuccessPeminjaman($peminjaman));
    }
}
