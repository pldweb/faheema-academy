<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    // Konfigurasi Primary Key String (Wajib!)
    protected $primaryKey = 'kode';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = [];

    // Relasi ke Kabupaten (One to Many)
    public function kabupatens()
    {
        return $this->hasMany(Kabupaten::class, 'kode_provinsi', 'kode');
    }
}
