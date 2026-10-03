<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun Super Admin
        User::firstOrCreate(
            ['email' => 'admin@himasi.com'],
            [
                'name' => 'Administrator',
                'nim' => 'ADMIN',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'jabatan' => 'Sistem Administrator',
            ]
        );

        // Eksekusi seeder tim
        $this->call([
            TeamSeeder::class
        ]);
    }
}
