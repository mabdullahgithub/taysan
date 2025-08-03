<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@glowzel.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567890',
            'address' => '123 Admin Street',
            'city' => 'Admin City',
            'country' => 'USA',
            'postal_code' => '12345',
            'date_of_birth' => '1990-01-01',
            'gender' => 'male',
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Create Test Users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'phone' => '+1234567891',
                'address' => '456 Test Avenue',
                'city' => 'Test City',
                'country' => 'USA',
                'postal_code' => '54321',
                'date_of_birth' => '1985-05-15',
                'gender' => 'male',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'phone' => '+1234567892',
                'address' => '789 Demo Road',
                'city' => 'Demo City',
                'country' => 'Canada',
                'postal_code' => '67890',
                'date_of_birth' => '1992-08-22',
                'gender' => 'female',
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'phone' => '+1234567893',
                'address' => '321 Sample Lane',
                'city' => 'Sample City',
                'country' => 'UK',
                'postal_code' => '98765',
                'date_of_birth' => '1988-12-03',
                'gender' => 'male',
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@example.com',
                'phone' => '+1234567894',
                'address' => '654 Example Boulevard',
                'city' => 'Example City',
                'country' => 'Australia',
                'postal_code' => '45678',
                'date_of_birth' => '1995-03-18',
                'gender' => 'female',
            ],
        ];

        foreach ($users as $userData) {
            User::create(array_merge($userData, [
                'password' => Hash::make('password'),
                'role' => User::ROLE_USER,
                'is_active' => true,
                'email_verified_at' => now(),
            ]));
        }

        // Create some inactive users
        User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@example.com',
            'password' => Hash::make('password'),
            'phone' => '+1234567895',
            'role' => User::ROLE_USER,
            'is_active' => false,
            'email_verified_at' => now(),
        ]);

        echo "Created " . User::count() . " users.\n";
    }
}
