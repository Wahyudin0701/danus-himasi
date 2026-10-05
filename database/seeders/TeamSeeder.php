<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bidang;
use Illuminate\Support\Facades\Hash;

class TeamSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Bidang
        $kewirausahaan = Bidang::firstOrCreate(['name' => 'Kewirausahaan']);
        $sosmed = Bidang::firstOrCreate(['name' => 'Sosial dan Branding']);

        $team = [
            [
                'name' => 'M. Wahyudin',
                'nim' => 'F1E123063',
                'role' => 'kadiv',
                'angkatan' => '2023',
                'jabatan' => 'Ketua Divisi',
                'bidang_id' => null,
            ],
            [
                'name' => 'Rio Saputra',
                'nim' => 'F1E123101',
                'role' => 'wakadiv',
                'angkatan' => '2023',
                'jabatan' => 'Wakil Ketua Divisi',
                'bidang_id' => null,
            ],
            [
                'name' => 'Laila Nazelita',
                'nim' => 'F1E123003',
                'role' => 'sekretaris',
                'angkatan' => '2023',
                'jabatan' => 'Sekretaris Divisi',
                'bidang_id' => null,
            ],
            [
                'name' => 'Nadia Julia Fika',
                'nim' => 'F1E124018',
                'role' => 'bendahara',
                'angkatan' => '2024',
                'jabatan' => 'Bendahara Divisi',
                'bidang_id' => null,
            ],
            [
                'name' => 'Friska Marchella',
                'nim' => 'F1E124069',
                'role' => 'anggota', // Ketua bidang
                'angkatan' => '2024',
                'jabatan' => 'Ketua Bidang Kewirausahaan',
                'bidang_id' => $kewirausahaan->id,
            ],
            [
                'name' => 'Wisnu Nugroho',
                'nim' => 'F1E124032',
                'role' => 'anggota', // Ketua bidang
                'angkatan' => '2024',
                'jabatan' => 'Ketua Bidang Sosial dan Branding',
                'bidang_id' => $sosmed->id,
            ],
            [
                'name' => 'Gibran Krisna Athallah',
                'nim' => 'F1E123034',
                'role' => 'anggota',
                'angkatan' => '2023',
                'jabatan' => 'Anggota Bidang Kewirausahaan',
                'bidang_id' => $kewirausahaan->id,
            ],
            [
                'name' => 'Hilmy Anandika Indra',
                'nim' => 'F1E123005',
                'role' => 'anggota',
                'angkatan' => '2023',
                'jabatan' => 'Anggota Bidang Sosial dan Branding',
                'bidang_id' => $sosmed->id,
            ],
        ];

        foreach ($team as $member) {
            User::firstOrCreate(
                ['nim' => $member['nim']],
                [
                    'name' => $member['name'],
                    'email' => $member['email'] ?? strtolower($member['nim']) . '@himasi.com',
                    'password' => Hash::make('password'),
                    'role' => $member['role'],
                    'angkatan' => $member['angkatan'],
                    'jabatan' => $member['jabatan'],
                    'bidang_id' => $member['bidang_id'],
                ]
            );
        }
    }
}


