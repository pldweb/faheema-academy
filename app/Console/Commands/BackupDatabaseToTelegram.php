<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class BackupDatabaseToTelegram extends Command
{
    protected $signature = 'db:backup-telegram';

    protected $description = 'Backup database dan kirim ke Telegram Grup';

    public function handle()
    {
        $this->info('Memulai proses backup...');

        $dbName = config('database.connections.mysql.database');
        $dbUser = config('database.connections.mysql.username');
        $dbPass = config('database.connections.mysql.password');
        $dbHost = config('database.connections.mysql.host');

        $date = now()->format('Y-m-d_H-i-s');
        $fileName = "backup-{$dbName}-{$date}.sql";
        $filePath = storage_path("app/{$fileName}");

        $command = "mysqldump --user='{$dbUser}' --password='{$dbPass}' --host='{$dbHost}' '{$dbName}' > '{$filePath}'";

        $this->info('Sedang melakukan dumping database...');
        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            $this->error('Gagal melakukan backup database.');

            return;
        }

        $this->info('Mengirim ke Telegram...');

        $botToken = env('TELEGRAM_BOT_TOKEN'); // Masukkan di .env
        $chatId = env('TELEGRAM_CHAT_ID');     // Masukkan di .env

        $response = Http::attach(
            'document', file_get_contents($filePath), $fileName
        )->post("https://api.telegram.org/bot{$botToken}/sendDocument", [
            'chat_id' => $chatId,
            'caption' => "📦 **Database Backup**: {$dbName}\n📅 **Tanggal**: ".now()->toDateTimeString(),
            'parse_mode' => 'Markdown',
            'message_thread_id' => 4,
        ]);

        if ($response->successful()) {
            $this->info('Sukses mengirim ke Telegram!');

            unlink($filePath);
            $this->info('File lokal dihapus.');
        } else {
            $this->error('Gagal mengirim ke Telegram: '.$response->body());
        }
    }
}
