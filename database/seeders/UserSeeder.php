<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Administrator
        User::create([
            'name' => 'Administrator Donasi',
            'email' => 'admin@donasi.org',
            'password' => Hash::make('password'),
            'role' => 'Administrator',
        ]);

        // Create Operator
        User::create([
            'name' => 'Operator Donasi',
            'email' => 'operator@donasi.org',
            'password' => Hash::make('password'),
            'role' => 'Operator',
        ]);
    }
}
