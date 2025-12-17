<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Throwable;

class ImportLokasi extends Command
{
    protected $signature = 'app:import-lokasi';

    protected $description = 'Ambil data lokasi dari 4 API Nusakita';

    public function handle()
    {
        // 1. Matikan batasan Memori & Waktu Eksekusi (PENTING BUAT DATA BESAR)
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);

        $this->info('🚀 Memulai proses impor data lokasi.');
        $this->comment('Proses ini memakan waktu lama (terutama Kelurahan ~83k data). Mohon bersabar...');

        // 2. Matikan pengecekan Foreign Key sementara
        // Agar kalau ada kode_kecamatan yang nyangkut/salah, proses tidak berhenti total
        Schema::disableForeignKeyConstraints();

        $endpoints = [
            'provinsi' => 'https://api-nusantarakita.vercel.app/v2/provinsi?pagination=false',
            'kabupaten' => 'https://api-nusantarakita.vercel.app/v2/kab-kota?pagination=false',
            'kecamatan' => 'https://api-nusantarakita.vercel.app/v2/kecamatan?pagination=false',
            'kelurahan' => 'https://api-nusantarakita.vercel.app/v2/desa-kel?pagination=false',
        ];

        try {
            // PROVINSI
            $this->processEndpoint($endpoints['provinsi'], 'provinsis', [
                'kode' => 'kode', 'nama' => 'nama', 'lat' => 'lat', 'lng' => 'lng',
            ]);

            // KABUPATEN
            $this->processEndpoint($endpoints['kabupaten'], 'kabupatens', [
                'kode' => 'kode', 'nama' => 'nama', 'kode_provinsi' => 'kode_provinsi',
                'lat' => 'lat', 'lng' => 'lng',
            ]);

            // KECAMATAN
            $this->processEndpoint($endpoints['kecamatan'], 'kecamatans', [
                'kode' => 'kode', 'nama' => 'nama', 'kode_kabupaten' => 'kode_kabupaten_kota',
                'lat' => 'lat', 'lng' => 'lng',
            ]);

            // KELURAHAN
            $this->processEndpoint($endpoints['kelurahan'], 'kelurahans', [
                'kode' => 'kode', 'nama' => 'nama', 'kode_kecamatan' => 'kode_kecamatan',
                'kode_pos' => 'kode_pos', // Pastikan kolom di DB namanya 'kode_pos'
                'lat' => 'lat', 'lng' => 'lng',
            ]);

            $this->info('✅ Semua data lokasi berhasil diimpor.');

        } catch (Throwable $e) {
            $this->error('Terjadi kesalahan fatal: '.$e->getMessage());
        } finally {
            // 3. Hidupkan kembali Foreign Key Checks (Wajib!)
            Schema::enableForeignKeyConstraints();
        }

        return 0;
    }

    protected function processEndpoint(string $url, string $tableName, array $columnMapping)
    {
        $this->newLine();
        $this->comment("⬇️ Mengambil data untuk tabel: {$tableName}...");

        try {
            $response = Http::timeout(120)->get($url); // Tambah timeout request

            if (! $response->successful()) {
                $this->error("❌ Gagal request URL: {$url} (Status: ".$response->status().')');

                return;
            }

            $json = $response->json();

            // Validasi struktur JSON
            if (! isset($json['data'])) {
                $this->error("❌ Format JSON tidak sesuai (key 'data' tidak ditemukan).");

                return;
            }

            $data = $json['data'];
            $total = count($data);
            $this->info("📦 {$total} data ditemukan. Memasukkan ke database...");

            // Perkecil Chunk size jadi 250 agar query SQL tidak kepanjangan
            $chunks = array_chunk($data, 250);

            $progressBar = $this->output->createProgressBar($total);
            $progressBar->start();

            foreach ($chunks as $chunk) {
                $insertData = [];
                foreach ($chunk as $item) {
                    $newItem = [];
                    foreach ($columnMapping as $dbColumn => $apiColumn) {
                        // Tambahan: Pastikan nilai null aman
                        $val = $item[$apiColumn] ?? null;
                        $newItem[$dbColumn] = $val;
                    }
                    $insertData[] = $newItem;
                }

                // Bungkus upsert per chunk dengan try-catch
                // Biar kalau 1 chunk gagal, kita tau errornya apa
                try {
                    DB::table($tableName)->upsert($insertData, ['kode']); // Upsert berdasarkan 'kode'
                } catch (\Exception $ex) {
                    // Tampilkan error spesifik SQL nya
                    $this->newLine();
                    $this->error('⚠️ Gagal insert di chunk ini: '.$ex->getMessage());
                }

                $progressBar->advance(count($chunk));
            }

            $progressBar->finish();
            $this->info(" -> Selesai {$tableName}");

        } catch (\Exception $e) {
            $this->error("Gagal memproses endpoint {$tableName}: ".$e->getMessage());
        }
    }
}
