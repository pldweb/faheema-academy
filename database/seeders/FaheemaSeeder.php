<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;
use App\Models\Program;
use App\Models\Kelas;
use App\Models\Paket;
use App\Models\User;
use Spatie\Permission\Models\Role;

class FaheemaSeeder extends Seeder
{
    public function run()
    {
        // 1. Buat User Admin/Test
        $user = User::create([
            'nama' => 'Santri Test',
            'email' => 'santri@faheema.com',
            'password' => bcrypt('password'),
        ]);

        $role = Role::firstOrCreate(['name' => 'anggota', 'guard_name' => 'web']);

        $user->assignRole($role);

        // 2. Buat Paket Harga (Sesuai Screenshot kamu)
        $paketA = Paket::create([
            'nama_paket' => 'Regular Paket A',
            'tipe' => 'reguler',
            'deskripsi' => 'Solusi dasar untuk kebutuhan transaksi digital',
            'harga' => 75000,
            'fasilitas' => 'Akses Materi Dasar, Ujian Harian',
        ]);

        Paket::create([
            'nama_paket' => 'Privat Paket A',
            'tipe' => 'privat',
            'deskripsi' => 'Bebas pilih waktu, materi personal',
            'harga' => 400000,
            'fasilitas' => '1 on 1 dengan Ustadz, Rekaman Zoom',
        ]);

        // 3. Buat Kategori & Program
        $kat = Kategori::create(['nama' => 'Quran', 'slug' => 'quran']);

        $prog1 = Program::create([
            'kategori_id' => $kat->id,
            'nama' => 'Tahsin & Tahfidz',
            'slug' => 'tahsin-tahfidz',
            'deskripsi' => 'Perbaiki bacaan dan hafalanmu.'
        ]);

        // 4. Buat Kelas
        Kelas::create([
            'program_id' => $prog1->id,
            'nama' => 'Tahsin Pra Dasar',
            'slug' => 'tahsin-pra-dasar',
            'deskripsi' => 'Kelas untuk pemula yang baru belajar huruf hijaiyah.',
            'aktif' => true
        ]);

        Kelas::create([
            'program_id' => $prog1->id,
            'nama' => 'Talaqqi Juz 30',
            'slug' => 'talaqqi-juz-30',
            'deskripsi' => 'Setoran hafalan juz amma dengan sanad.',
            'aktif' => true
        ]);
    }
}
