<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Kenneth John C. Ribay',
            'email' => 'kennethjohnribay@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'), // Change this to a secure password
        ]);

        $this->command->info('Admin user created successfully!');
        $this->command->info('Email: kennethjohnribay@gmail.com');
        $this->command->info('Password: admin123');
        $this->command->warn('Please change the password after first login!');
    }
}
