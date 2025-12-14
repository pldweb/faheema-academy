<?php

namespace App\Helper;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramHelper
{
    public static function sendNotification($msg = 'Ini sebenarnya null', $parseMode = 'Markdown')
    {
        $msg .= "\n";
        $msg .= 'Dilakukan Oleh: '.'*'.User::panggilNamaUser()."*\n";
        $msg .= 'Dikirim dari '.env('APP_URL');
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $msg,
            'parse_mode' => $parseMode,
            'message_thread_id' => 4,
        ]);
        Log::info('Proses Telegram Notif');
    }

    public static function sendMsg($msg = 'Ini sebenarnya null', $parseMode = 'Markdown')
    {
        Telegram::sendMessage([
            'chat_id' => env('TELEGRAM_CHAT_ID'),
            'text' => $msg,
            'parse_mode' => $parseMode,
            'message_thread_id' => 4,
        ]);
    }
}
