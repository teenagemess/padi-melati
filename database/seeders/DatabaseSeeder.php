<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'username' => 'admin',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'is_admin' => true
        ]);

        User::factory()->create([
            'name' => 'Raynanda Aqiyas',
            'email' => 'rpramardika@gmail.com',
            'email_verified_at' => now(),
            'username' => 'tokyogetto',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'is_admin' => false
        ]);
    }
}
