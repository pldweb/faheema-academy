<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';
    protected $guarded = ['id'];

    // Relasi: Milik Kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi: Punya banyak Kelas
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'program_id');
    }
}
