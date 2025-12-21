<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'id',
        'kode_user',
        'nama',
        'email',
        'no_telp',
        'password',
        'kelurahan_kode',
        'alamat_detail',
        'tanggal_lahir',
        'jenis_kelamin',
        'role',
        'photo',
        'email_verified_at',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public static function panggilNamaUser()
    {
        return optional(auth()->user())->nama;
    }

    public function wilayah()
    {
        return $this->belongsTo(Kelurahan::class, 'kelurahan_kode', 'kode');
    }

    public function getRoleName()
    {
        return $this->getRoleNames()->first() ?? '-';
    }
}
