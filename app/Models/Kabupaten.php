<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kabupaten extends Model
{
    protected $primaryKey = 'kode';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = [];

    // Relasi ke Atas (Provinsi)
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class, 'kode_provinsi', 'kode');
    }

    // Relasi ke Bawah (Kecamatan)
    public function kecamatans()
    {
        return $this->hasMany(Kecamatan::class, 'kode_kabupaten', 'kode');
    }
}
