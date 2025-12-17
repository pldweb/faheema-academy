<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::firstOrCreate(['name' => 'administrator', 'guard_name' => 'web']);

        $user = User::updateOrCreate(
            ['email' => 'admin@rinkweb.it'],
            [
                'nama' => 'Super Administrator',
                'password' => Hash::make('rinkweb.it'),
                'email_verified_at' => now(),
            ]
        );

        $user->assignRole($role);
        $this->command->info("✅ User 'admin@rinkweb.it' berhasil dibuat dengan role 'administrator'!");
    }
}
