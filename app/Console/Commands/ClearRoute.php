<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class ClearRoute extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-route';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $this->info('🚀 Memulai proses refresh cache...');

        Artisan::call('optimize:clear');
        $this->info('✔ Framework cache cleared (Config, Route, View)');

        Artisan::call('cache:clear');
        $this->info('✔ Application data cache cleared');

//        Artisan::call('app:sync-permissions');
//        $this->info('✔ Permissions synced');

        Artisan::call('optimize');
        $this->info('✔ Optimization files generated (Config & Routes)');

        Artisan::call('view:cache');
        $this->info('✔ Views compiled');

        Artisan::call('queue:restart');
        $this->info('✔ Queue worker restarted');

        $this->info('✅ SUKSES! Sistem sudah segar kembali.');

    }
}
