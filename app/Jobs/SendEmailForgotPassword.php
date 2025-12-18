<?php

namespace App\Jobs;

use App\Mail\SendEmailForgotPasswordMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendEmailForgotPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $url;

    public function __construct($data, $url)
    {
        $this->data = $data;
        $this->url = $url;
    }

    public function handle(): void
    {
        Mail::to($this->data->email)->send(new SendEmailForgotPasswordMail($this->data, $this->url));
    }

    public function failed(Throwable $exception): void
    {
        Log::error('JOB GAGAL TOTAL BOSKU: ' . $exception->getMessage());
        Log::error($exception->getTraceAsString());
    }
}
