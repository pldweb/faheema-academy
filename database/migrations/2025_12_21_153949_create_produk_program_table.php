<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kategori_produk', function (Blueprint $table) {
            $table->string('slug')->unique()->after('nama');
            $table->text('deskripsi')->nullable()->after('slug');
        });

        Schema::create('program', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori_produk')->cascadeOnDelete();
            $table->string('nama')->nullable();
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_id')->constrained('program')->cascadeOnDelete();
            $table->string('nama'); // Contoh: "Tahsin Pra Dasar"
            $table->string('slug')->unique();
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail')->nullable();
            $table->boolean('aktif')->default(true); // Status kelas aktif/tidak
            $table->timestamps();
        });

        Schema::create('paket', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket'); // Contoh: "Regular Paket A"
            $table->string('tipe'); // regular atau private Untuk filter di frontend
            $table->decimal('harga', 12, 0); // Contoh: 75000 (tanpa koma desimal untuk IDR)
            $table->integer('durasi_hari')->default(30); // 30 hari
            $table->text('fasilitas')->nullable(); // Simpan list fitur
            $table->text('deskripsi')->nullable();
            $table->string('thumbnail')->nullable();
            $table->timestamps();
        });

        Schema::create('webinar', function (Blueprint $table) {
            $table->id();
            $table->string('judul');            // Judul Webinar
            $table->string('slug')->unique();
            $table->string('pemateri')->nullable();         // Nama Ustadz/Pembicara
            $table->text('deskripsi')->nullable();          // Penjelasan webinar
            $table->string('poster')->nullable(); // Gambar flyer

            $table->date('tanggal_mulai');      // Kapan acaranya
            $table->time('jam_mulai')->nullable();          // Jam berapa

            $table->decimal('harga', 12, 0)->default(0); // Kalau 0 berarti Gratis
            $table->string('link_zoom')->nullable();     // Link meeting (muncul setelah bayar)

            $table->integer('kuota')->default(100);      // Batas peserta
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->unique(); // ID Unik buat Midtrans (cth: TRX-12345)

            // Relasi ke User (bawaan Laravel biasanya tabelnya tetap 'users' bahasa inggris)
            $table->foreignId('user_id')->constrained('users');

            // Relasi ke Kelas & Paket
            $table->foreignId('kelas_id')->nullable()->constrained('kelas');
            $table->foreignId('paket_id')->nullable()->constrained('paket');
            $table->foreignId('webinar_id')->nullable()->constrained('webinar');

            $table->decimal('total_bayar', 12, 0); // Nominal akhir

            // Status Pembayaran: 'menunggu', 'lunas', 'gagal', 'kadaluarsa'
            $table->string('status_pembayaran')->default('menunggu');

            $table->string('snap_token')->nullable(); // Token popup Midtrans
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_program');
    }
};
