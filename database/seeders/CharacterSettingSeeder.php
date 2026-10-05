<?php

namespace Database\Seeders;

use App\Models\CharacterSetting;
use Illuminate\Database\Seeder;

class CharacterSettingSeeder extends Seeder
{
    public function run(): void
    {
        $characters = [
            ['filename' => 'Big-Head Blue Jacket Caricature.png',       'display_name' => 'Jaket Biru (Cowok)',       'sort_order' => 1],
            ['filename' => 'Big-Head Student in Navy Uniform.png',       'display_name' => 'Seragam Navy (Cowok)',     'sort_order' => 2],
            ['filename' => 'Big-Head Student in Navy.png',               'display_name' => 'Baju Navy (Cowok)',        'sort_order' => 3],
            ['filename' => 'Chibi Uniformed Student with ID Card.png',   'display_name' => 'Seragam + ID Card',        'sort_order' => 4],
            ['filename' => 'Chibi University Utility Jacket Character.png','display_name' => 'Jaket Kampus',           'sort_order' => 5],
            ['filename' => 'Big-Head Student.png',                       'display_name' => 'Kasual (Cowok)',           'sort_order' => 6],
            ['filename' => 'Chibi Hijabi Student Sticker Pose.png',      'display_name' => 'Hijabi Sticker (Cewek)',   'sort_order' => 7],
            ['filename' => 'Smiling Hijabi Caricature with Rupiah.png',  'display_name' => 'Hijabi + Rupiah (Cewek)',  'sort_order' => 8],
        ];

        foreach ($characters as $char) {
            CharacterSetting::updateOrCreate(
                ['filename' => $char['filename']],
                [
                    'display_name'  => $char['display_name'],
                    'show_on_home'  => true,
                    'show_on_login' => true,
                    'sort_order'    => $char['sort_order'],
                ]
            );
        }
    }
}
