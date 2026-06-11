<?php

namespace Database\Seeders;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\DonationType;
use App\Models\User;
use Illuminate\Database\Seeder;

class DonationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $donors = Donor::all();
        $types = DonationType::all();
        $users = User::all();

        if ($donors->isEmpty() || $types->isEmpty() || $users->isEmpty()) {
            return;
        }

        $methods = ['Tunai', 'Transfer Bank', 'QRIS', 'E-Wallet'];
        $statuses = ['Selesai', 'Selesai', 'Selesai', 'Draft', 'Dibatalkan'];

        // Seed 60 donations across the last 3 months
        for ($i = 0; $i < 60; $i++) {
            $donor = $donors->random();
            $type = $types->random();
            $user = $users->random();

            // Distribute dates over last 90 days
            $date = now()->subDays(rand(0, 90))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            Donation::create([
                'donation_date' => $date,
                'donor_id' => $donor->id,
                'donation_type_id' => $type->id,
                'amount' => rand(5, 500) * 10000, // 50,000 to 5,000,000
                'payment_method' => $methods[array_rand($methods)],
                'notes' => rand(0, 1) ? 'Donasi ikhlas untuk program ' . $type->name : null,
                'user_id' => $user->id,
                'status' => $statuses[array_rand($statuses)],
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
