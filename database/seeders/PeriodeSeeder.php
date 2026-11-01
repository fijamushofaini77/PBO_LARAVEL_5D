<?php

namespace Database\Seeders;

use App\Models\Periode;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periodes = [
            [
                'periode' => 'GANJIL 2026/2027',
                'singkatan' => '261',
                'status' => true,
            ],
            [
                'periode' => 'GENAP 2026/2027',
                'singkatan' => '262',
                'status' => false,
            ],
            [
                'periode' => 'GANJIL 2027/2028',
                'singkatan' => '271',
                'status' => false,
            ],
            [
                'periode' => 'GENAP 2027/2028',
                'singkatan' => '272',
                'status' => false,
            ],
        ];

        foreach ($periodes as $data) {
            Periode::firstOrCreate(
                ['singkatan' => $data['singkatan']],
                $data
            );
        }
    }
}
