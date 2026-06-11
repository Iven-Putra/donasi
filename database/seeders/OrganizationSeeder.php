<?php

namespace Database\Seeders;

use App\Models\Organization;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organization::create([
            'name' => 'Yayasan Amal Peduli Sesama',
            'logo' => null,
            'address' => 'Jl. Merdeka No. 45, Kebayoran Baru',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'postal_code' => '12190',
            'phone' => '021-7279898',
            'email' => 'info@amalpeduli.org',
            'website' => 'https://amalpeduli.org',
            'chairman_name' => 'H. Rahmat Hidayat, M.A.',
            'treasurer_name' => 'Hj. Ratna Sari, S.E.',
            'tax_number' => '01.234.567.8-012.000',
        ]);
    }
}
