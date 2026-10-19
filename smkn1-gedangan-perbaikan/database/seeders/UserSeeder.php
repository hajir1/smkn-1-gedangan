<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use RuntimeException;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('PASS_SEED');

        // Dulu jika PASS_SEED kosong, akun admin dibuat dengan password kosong.
        if (blank($password) || strlen($password) < 10) {
            throw new RuntimeException('Isi PASS_SEED di .env (minimal 10 karakter) sebelum menjalankan seeder.');
        }

        $admins = [
            ['name' => 'admin', 'email' => 'smknega@gmail.com', 'deletable' => false],
            ['name' => 'usammuhajir', 'email' => 'usammuhajir047@gmail.com', 'deletable' => true],
        ];

        foreach ($admins as $admin) {
            User::query()->firstOrNew(['email' => $admin['email']])->forceFill([
                'name' => $admin['name'],
                'password' => $password,
                'role' => User::ROLE_ADMIN,
                'deletable' => $admin['deletable'],
                'email_verified_at' => now(),
            ])->save();
        }
    }
}
