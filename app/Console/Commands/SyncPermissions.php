<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use ReflectionClass;
use ReflectionMethod;
use Spatie\Permission\Models\Permission;

class SyncPermissions extends Command
{
    protected $signature = 'app:sync-permissions';

    protected $description = 'Command description';

    public function handle()
    {
        $this->info('🤖 Robot Scanner mulai bekerja...');

        // Sesuaikan lokasi controller
        $controllerPath = app_path('Http/Controllers');
        $namespace = 'App\Http\Controllers';

        // Reset cache permission biar update
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $this->scanFolder($controllerPath, $namespace);

        $this->info('✅ Selesai! Semua permission sudah didaftarkan ke database.');
    }

    protected function scanFolder($folder, $namespace)
    {
        $files = scandir($folder);
        foreach ($files as $file) {
            if ($file === '.' || $file === '..') {
                continue;
            }

            $fullPath = $folder.DIRECTORY_SEPARATOR.$file;
            $filename = pathinfo($file, PATHINFO_FILENAME);

            if (is_dir($fullPath)) {
                // Rekursif ke subfolder
                $this->scanFolder($fullPath, $namespace.'\\'.$filename);
            } elseif (str_ends_with($file, 'Controller.php')) {
                $controllerClass = $namespace.'\\'.$filename;
                if (class_exists($controllerClass)) {
                    $this->processController($controllerClass);
                }
            }
        }
    }

    protected function processController($controllerClass)
    {
        $reflection = new ReflectionClass($controllerClass);
        $methods = $reflection->getMethods(ReflectionMethod::IS_PUBLIC);
        $controllerName = $reflection->getShortName();

        // Ubah "ProductController" jadi "product"
        $resourceName = Str::kebab(str_replace('Controller', '', $controllerName));

        foreach ($methods as $method) {
            if ($method->class !== $controllerClass || $method->isConstructor()) {
                continue;
            }

            // Ambil method yang diawali get, post, put, delete
            preg_match('/^(get|post|put|delete|patch)(.+)$/', $method->name, $matches);

            if (count($matches) === 3) {
                [$fullMatch, $verb, $actionRaw] = $matches;

                // Ubah "postCreate" jadi "create"
                $action = Str::kebab($actionRaw);
                if ($action === 'index' || empty($action)) {
                    $action = 'index';
                }

                // Hasil akhir: "product.create"
                $permissionName = $resourceName.'.'.$action;

                // Simpan ke DB jika belum ada
                Permission::firstOrCreate(['name' => $permissionName, 'guard_name' => 'web']);

                $this->line("   👉 Menemukan: <comment>$permissionName</comment>");
            }
        }
    }
}
