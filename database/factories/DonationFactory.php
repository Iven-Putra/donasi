<?php

namespace Database\Factories;

use App\Models\Donation;
use App\Models\Donor;
use App\Models\DonationType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    protected $model = Donation::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $methods = ['Tunai', 'Transfer Bank', 'QRIS', 'E-Wallet'];
        $statuses = ['Selesai', 'Selesai', 'Selesai', 'Draft', 'Dibatalkan']; // Mostly Selesai

        return [
            'donation_date' => fake()->dateTimeBetween('-3 months', 'now'),
            'donor_id' => Donor::factory(),
            'donation_type_id' => DonationType::factory(),
            'amount' => fake()->randomElement([10000, 25000, 50000, 100000, 250000, 500000, 1000000, 2500000, 5000000]),
            'payment_method' => fake()->randomElement($methods),
            'notes' => fake()->optional()->sentence(),
            'user_id' => User::factory(),
            'status' => fake()->randomElement($statuses),
        ];
    }
}
