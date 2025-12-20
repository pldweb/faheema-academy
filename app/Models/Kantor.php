<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kantor extends Model
{
    protected $table = 'kantor';

    protected $fillable = [
        'nama_perusahaan',
        'kelurahan_kode',
        'alamat_detail',
        'email',
        'nomor_telepon',
        'nomor_handphone',
        'latitude',
        'longitude',
        'tagline',
        'logo',
        'favicon',
        'logo_invert',
    ];

    public function wilayah()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_kode', 'kode');
    }
}
