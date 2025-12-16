<?php

namespace App\Jobs;

use App\Helper\TelegramHelper;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class TelegramJob implements ShouldQueue
{
    use Queueable;

    public $msg;

    public $markdown;

    public function __construct($msg, $markdown = 'Markdown')
    {
        $this->msg = $msg;
        $this->markdown = $markdown;
    }

    public function handle(): void
    {
        TelegramHelper::sendNotification($this->msg, 'Markdown');
    }
}
