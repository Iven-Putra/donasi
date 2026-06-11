<?php

namespace Database\Factories;

use App\Models\Donor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donor>
 */
class DonorFactory extends Factory
{
    protected $model = Donor::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Perorangan', 'Perusahaan', 'Komunitas'];
        $cities = ['Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Medan', 'Yogyakarta', 'Makassar'];
        $provinces = ['DKI Jakarta', 'Jawa Barat', 'Jawa Timur', 'Jawa Tengah', 'Sumatera Utara', 'DI Yogyakarta', 'Sulawesi Selatan'];
        $index = fake()->numberBetween(0, count($cities) - 1);

        return [
            'donor_type' => fake()->randomElement($types),
            'name' => fake()->name(),
            'phone' => '08' . fake()->unique()->numerify('##########'),
            'email' => fake()->unique()->safeEmail(),
            'address' => fake()->address(),
            'city' => $cities[$index],
            'province' => $provinces[$index],
            'join_date' => fake()->date('Y-m-d', 'now'),
            'is_active' => true,
        ];
    }
}
