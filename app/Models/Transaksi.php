<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $guarded = ['id'];

    // Casting
    protected $casts = [
        'total_bayar' => 'integer',
        'payment_details' => 'array', // Jika menyimpan respon Midtrans
    ];

    // --- RELASI ---

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }

    public function webinar()
    {
        return $this->belongsTo(Webinar::class, 'webinar_id');
    }

    // --- AKSESOR PINTAR (MAGIC) ---

    // Cara pakai: $transaksi->nama_produk
    // Dia otomatis ngecek ini Webinar atau Kelas
    public function getNamaProdukAttribute()
    {
        if ($this->tipe_produk === 'webinar' && $this->webinar) {
            return "Webinar: " . $this->webinar->judul;
        }

        if ($this->tipe_produk === 'kelas' && $this->kelas) {
            $namaPaket = $this->paket ? " (" . $this->paket->nama_paket . ")" : "";
            return "Kelas: " . $this->kelas->nama . $namaPaket;
        }

        return "Produk Tidak Dikenal";
    }

    // Cara pakai: $transaksi->status_warna (Buat label Bootstrap/Tailwind)
    public function getStatusWarnaAttribute()
    {
        return match ($this->status_pembayaran) {
            'lunas' => 'success',      // Hijau
            'menunggu' => 'warning',   // Kuning
            'gagal' => 'danger',       // Merah
            'kadaluarsa' => 'secondary', // Abu-abu
            default => 'primary',
        };
    }
}
