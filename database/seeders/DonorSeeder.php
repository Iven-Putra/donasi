<?php

namespace Database\Seeders;

use App\Models\Donor;
use Illuminate\Database\Seeder;

class DonorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donors = [
            [
                'donor_type' => 'Perorangan',
                'name' => 'Budi Santoso',
                'phone' => '081234567890',
                'email' => 'budi.santoso@gmail.com',
                'address' => 'Jl. Mawar No. 12',
                'city' => 'Jakarta Selatan',
                'province' => 'DKI Jakarta',
                'join_date' => '2026-01-15',
                'is_active' => true,
            ],
            [
                'donor_type' => 'Perorangan',
                'name' => 'Siti Aminah',
                'phone' => '082198765432',
                'email' => 'siti.aminah@yahoo.com',
                'address' => 'Jl. Melati No. 4',
                'city' => 'Bandung',
                'province' => 'Jawa Barat',
                'join_date' => '2026-02-10',
                'is_active' => true,
            ],
            [
                'donor_type' => 'Perusahaan',
                'name' => 'PT Maju Jaya Abadi',
                'phone' => '0215554321',
                'email' => 'info@majujaya.co.id',
                'address' => 'Sudirman Central Business District Lt. 15',
                'city' => 'Jakarta Pusat',
                'province' => 'DKI Jakarta',
                'join_date' => '2026-03-01',
                'is_active' => true,
            ],
            [
                'donor_type' => 'Komunitas',
                'name' => 'Komunitas Peduli Sesama',
                'phone' => '087812345678',
                'email' => 'peduli.sesama@gmail.com',
                'address' => 'Jl. Cempaka No. 88',
                'city' => 'Surabaya',
                'province' => 'Jawa Timur',
                'join_date' => '2026-03-12',
                'is_active' => true,
            ],
            [
                'donor_type' => 'Perorangan',
                'name' => 'Hendra Wijaya',
                'phone' => '081399887766',
                'email' => 'hendra.w@outlook.com',
                'address' => 'Perum Indah Regency Blok B-5',
                'city' => 'Semarang',
                'province' => 'Jawa Tengah',
                'join_date' => '2026-04-05',
                'is_active' => true,
            ],
            [
                'donor_type' => 'Perusahaan',
                'name' => 'CV Makmur Sejahtera',
                'phone' => '0247654321',
                'email' => 'contact@makmursejahtera.com',
                'address' => 'Kawasan Industri Candi Blok A',
                'city' => 'Semarang',
                'province' => 'Jawa Tengah',
                'join_date' => '2026-04-20',
                'is_active' => true,
            ]
        ];

        foreach ($donors as $donor) {
            Donor::create($donor);
        }

        // Generate 15 more random donors
        Donor::factory()->count(15)->create();
    }
}
