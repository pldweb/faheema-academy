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
        Schema::create('provinsis', function (Blueprint $table) {
            $table->string('kode', 10)->primary();
            $table->string('nama');
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
        });

        Schema::create('kabupatens', function (Blueprint $table) {
            $table->string('kode', 10)->primary();
            $table->string('nama');
            $table->string('kode_provinsi', 10)->index();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
        });

        Schema::create('kecamatans', function (Blueprint $table) {
            $table->string('kode', 10)->primary();
            $table->string('nama');
            // Perhatikan ini: tipe data string buat kode relasi
            $table->string('kode_kabupaten', 10)->index();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
        });

        Schema::create('kelurahans', function (Blueprint $table) {
            $table->string('kode', 15)->primary();
            $table->string('nama');
            $table->string('kode_kecamatan', 10)->index();
            $table->string('kode_pos', 10)->nullable()->index();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
        });

        Schema::create('kantor', function (Blueprint $table) {
            $table->id();
            $table->string('nama_perusahaan');

            // Relasi ke wilayah
            $table->string('kelurahan_kode', 15)->nullable()->index();

            // Alamat
            $table->text('alamat_detail')->nullable();
            $table->string('kode_pos', 10)->nullable();

            // Kontak
            $table->string('email')->nullable();
            $table->string('tagline')->nullable();
            $table->string('nomor_telepon', 20)->nullable(); // Batasi length biar hemat
            $table->string('nomor_handphone', 20)->nullable();

            // Lokasi (Pilih String atau Decimal, Decimal lebih safe buat map)
            $table->string('latitude', 10, 8)->nullable();
            $table->string('longitude', 11, 8)->nullable();

            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('logo_invert')->nullable();

            $table->timestamps();
            $table->foreign('kelurahan_kode')->references('kode')->on('kelurahans')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lokasi_tables');
    }
};
