<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user (avoid factory autoload issues)
        User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Urban renewal sample data
        $this->call(UrbanRenewalSeeder::class);
        // User management seeds
        $this->call(\Database\Seeders\UserManagementSeeder::class);
        // RBAC sample data (roles & permissions)
        $this->call(\Database\Seeders\RbacSeeder::class);
    }
}
