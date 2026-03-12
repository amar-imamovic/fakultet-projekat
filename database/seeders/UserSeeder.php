<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'role_id' => 1
        ]);

        User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@moderator.com',
            'password' => 'password',
            'role_id' => 2
        ]);

        User::factory()->create([
            'name' => 'Franco',
            'email' => 'franco@franco.com',
            'password' => 'password'
        ]);
    }
}
