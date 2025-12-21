<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori_produk';
    protected $guarded = ['id'];

    // Relasi: Satu Kategori punya banyak Program
    public function program()
    {
        return $this->hasMany(Program::class, 'kategori_id');
    }
}
