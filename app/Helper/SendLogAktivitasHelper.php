<?php

namespace App\Helper;

use App\Models\LogAktivitas;

class SendLogAktivitasHelper
{
    public static function sendLogAktivitas($aksi)
    {
        $user = auth()->user()->nama;
        try {
            LogAktivitas::create([
                'aksi' => $aksi.' '.$user,
                'waktu' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}
