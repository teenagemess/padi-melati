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

        User::factory()->create([
            'name' => 'Raynanda Aqiyas1',
            'email' => 'rpramardika1@gmail.com',
            'email_verified_at' => now(),
            'username' => 'tokyogetto1',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'is_admin' => false
        ]);

        User::factory()->create([
            'name' => 'perempuan1',
            'email' => 'perempuan1@gmail.com',
            'email_verified_at' => now(),
            'username' => 'perempuan1',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'is_admin' => false
        ]);


        User::factory()->create([
            'name' => 'perempuan2',
            'email' => 'perempuan2@gmail.com',
            'email_verified_at' => now(),
            'username' => 'perempuan2',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'is_admin' => false
        ]);

        User::factory()->create([
            'name' => 'perempuan3',
            'email' => 'perempuan3@gmail.com',
            'email_verified_at' => now(),
            'username' => 'perempuan3',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'is_admin' => false
        ]);

        User::factory()->create([
            'name' => 'perempuan4',
            'email' => 'perempuan4@gmail.com',
            'email_verified_at' => now(),
            'username' => 'perempuan4',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'is_admin' => false
        ]);

        User::factory()->create([
            'name' => 'perempuan5',
            'email' => 'perempuan5@gmail.com',
            'email_verified_at' => now(),
            'username' => 'perempuan5',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'is_admin' => false
        ]);

        User::factory()->create([
            'name' => 'perempuan6',
            'email' => 'perempuan6@gmail.com',
            'email_verified_at' => now(),
            'username' => 'perempuan6',
            'password' => 'password',
            'remember_token' => Str::random(10),
            'is_admin' => false
        ]);
    }
}
