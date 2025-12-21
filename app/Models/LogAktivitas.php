<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;

class LogAktivitas extends Authenticatable
{
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'aksi',
        'waktu',
        'ip_address',
        'user_agent',
        'created_at',
        'updated_at',
    ];

    public function __get($key)
    {
        if (! isset($this)) {
            return null; // Kalau object-nya null, langsung kembalikan null
        }

        switch ($key) {
            case 'display_waktu':
                Carbon::setLocale('id');
                $waktu = Carbon::parse($this->waktu)->translatedFormat('l, d F Y H:i');

                return $waktu;
        }

        return parent::__get($key);
    }
}
