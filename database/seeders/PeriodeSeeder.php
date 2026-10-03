<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Periode;
use Illuminate\Support\Facades\DB;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        // Create the two initial periods
        $periode2024 = Periode::create([
            'name'       => '2024/2025',
            'year_start' => 2024,
            'year_end'   => 2025,
            'is_active'  => false,
        ]);

        $periode2025 = Periode::create([
            'name'       => '2025/2026',
            'year_start' => 2025,
            'year_end'   => 2026,
            'is_active'  => true, // current active period
        ]);

        $activeId = $periode2025->id;

        // Migrate all existing data to the active period (2025/2026)
        // This ensures no data is lost during the schema migration
        DB::table('users')
            ->whereNull('periode_id')
            ->where('role', '!=', 'admin')
            ->update(['periode_id' => $activeId]);

        DB::table('projects')
            ->whereNull('periode_id')
            ->update(['periode_id' => $activeId]);

        DB::table('kas_danuses')
            ->whereNull('periode_id')
            ->update(['periode_id' => $activeId]);

        DB::table('dokumens')
            ->whereNull('periode_id')
            ->update(['periode_id' => $activeId]);

        DB::table('messages')
            ->whereNull('periode_id')
            ->update(['periode_id' => $activeId]);

        $this->command->info("Periode seeder done. Created: 2024/2025 & 2025/2026 (active).");
        $this->command->info("All existing data assigned to periode 2025/2026.");
    }
}
