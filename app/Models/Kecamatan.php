<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    protected $primaryKey = 'kode';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    // Relasi ke Atas (Kabupaten)
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kode_kabupaten', 'kode');
    }

    // Relasi ke Bawah (Kelurahan)
    public function kelurahans()
    {
        return $this->hasMany(Kelurahan::class, 'kode_kecamatan', 'kode');
    }
}
