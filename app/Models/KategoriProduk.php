<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriProduk extends Model
{
    protected $table = 'kategori_produk';

    protected $fillable = [
        'id',
        'nama',
        'parent_id',
    ];

    public function parent()
    {
        return $this->belongsTo(KategoriProduk::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(KategoriProduk::class, 'parent_id');
    }
}
