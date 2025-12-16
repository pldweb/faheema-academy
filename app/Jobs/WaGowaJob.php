<?php

namespace App\Jobs;

use App\Helper\WhatsAppHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class WaGowaJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $no_telp;

    public $msg;

    public $tries = 3;

    public $timeout = 30;

    public function __construct($no_telp, $msg)
    {
        $this->no_telp = $no_telp;
        $this->msg = $msg;
    }

    public function handle(): void
    {
        WhatsAppHelper::sendGowa($this->no_telp, $this->msg);
    }
}
