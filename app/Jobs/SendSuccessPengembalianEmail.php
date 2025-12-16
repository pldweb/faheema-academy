<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendSuccessPengembalianEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;

    public $bukuKembali;

    public function __construct($user, $bukuKembali)
    {
        $this->user = $user;
        $this->bukuKembali = $bukuKembali;
    }

    public function handle(): void
    {

        Mail::to($this->user->email)->send(new \App\Mail\SendSuccessPengembalian($this->user, $this->bukuKembali));
    }
}
