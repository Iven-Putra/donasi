<?php

namespace Database\Factories;

use App\Models\DonationType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DonationType>
 */
class DonationTypeFactory extends Factory
{
    protected $model = DonationType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'JNS-' . fake()->unique()->numerify('###'),
            'name' => fake()->word() . ' ' . fake()->word(),
            'description' => fake()->sentence(),
            'is_active' => true,
        ];
    }
}
