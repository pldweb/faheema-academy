<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';
    protected $guarded = ['id'];

    // Scope untuk mempermudah filter kelas aktif: Kelas::aktif()->get()
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    // Relasi ke Transaksi (Melihat siapa saja yang beli kelas ini)
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'kelas_id');
    }
}
