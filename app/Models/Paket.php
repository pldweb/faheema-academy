<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    use HasFactory;

    protected $table = 'paket';
    protected $guarded = ['id'];

    // Casting agar data numerik tidak dianggap string
    protected $casts = [
        'harga' => 'integer',
        'harga_coret' => 'integer',
        // Jika fasilitas disimpan sebagai JSON, uncomment baris bawah:
        // 'fasilitas' => 'array',
    ];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'paket_id');
    }
}
