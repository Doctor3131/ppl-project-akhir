<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Test User Default - Disable 2FA
        User::factory()->withoutTwoFactor()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // User Taqi - Disable 2FA
        User::factory()->withoutTwoFactor()->create([
            'name' => 'Taqi',
            'email' => 'taqi@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // User Hidah - Disable 2FA
        User::factory()->withoutTwoFactor()->create([
            'name' => 'Hidah',
            'email' => 'hidah@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        // User Raya - Disable 2FA
        User::factory()->withoutTwoFactor()->create([
            'name' => 'Raya',
            'email' => 'raya@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
