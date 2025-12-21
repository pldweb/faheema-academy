<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webinar extends Model
{
    use HasFactory;

    protected $table = 'webinar';
    protected $guarded = ['id'];

    // Casting tanggal agar otomatis jadi object Carbon (bisa diformat tgl)
    protected $casts = [
        'tanggal_mulai' => 'date',
        'harga' => 'integer',
        'aktif' => 'boolean',
    ];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'webinar_id');
    }
}
