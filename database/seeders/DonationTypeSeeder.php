<?php

namespace Database\Seeders;

use App\Models\DonationType;
use Illuminate\Database\Seeder;

class DonationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            [
                'code' => 'JNS-001',
                'name' => 'Zakat',
                'description' => 'Zakat Fitrah, Zakat Maal, Zakat Penghasilan.',
                'is_active' => true,
            ],
            [
                'code' => 'JNS-002',
                'name' => 'Infaq',
                'description' => 'Infaq sukarela untuk kemaslahatan umum.',
                'is_active' => true,
            ],
            [
                'code' => 'JNS-003',
                'name' => 'Sedekah',
                'description' => 'Sedekah umum dan sosial keagamaan.',
                'is_active' => true,
            ],
            [
                'code' => 'JNS-004',
                'name' => 'Wakaf',
                'description' => 'Wakaf uang, wakaf tanah, pembangunan fasilitas ibadah/sosial.',
                'is_active' => true,
            ],
            [
                'code' => 'JNS-005',
                'name' => 'Donasi Sosial',
                'description' => 'Bantuan bencana alam, santunan yatim piatu, dan dhuafa.',
                'is_active' => true,
            ],
            [
                'code' => 'JNS-006',
                'name' => 'Donasi Pendidikan',
                'description' => 'Beasiswa santri/siswa berprestasi dan kurang mampu.',
                'is_active' => true,
            ],
        ];

        foreach ($types as $type) {
            DonationType::create($type);
        }
    }
}
